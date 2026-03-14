<?php

namespace Tests\Unit\Services\Public;

use Tests\TestCase;
use App\Models\Message;
use App\Models\User;
use App\Services\Public\MessageService;

class MessageServiceTest extends TestCase
{
    protected MessageService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new MessageService();
    }

    public function test_send_message()
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        $message = $this->service->sendMessage($sender->id, $receiver->id, 'Hello');

        $this->assertEquals($sender->id, $message->sender_id);
        $this->assertEquals($receiver->id, $message->receiver_id);
        $this->assertEquals('Hello', $message->content);
    }

    public function test_send_message_throws_exception_for_self_messaging()
    {
        $user = User::factory()->create();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Cannot send message to yourself.");

        $this->service->sendMessage($user->id, $user->id, 'Hello');
    }

    public function test_send_message_trims_content()
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        $message = $this->service->sendMessage($sender->id, $receiver->id, '  Hello  ');

        $this->assertEquals('Hello', $message->content);
    }

    public function test_get_conversation()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        Message::factory()->create(['sender_id' => $user1->id, 'receiver_id' => $user2->id, 'content' => 'msg1']);
        Message::factory()->create(['sender_id' => $user2->id, 'receiver_id' => $user1->id, 'content' => 'msg2']);

        $result = $this->service->getConversation($user1->id, $user2->id);

        $this->assertCount(2, $result->items());
    }

    public function test_get_inbox()
    {
        $receiver = User::factory()->create();
        $sender1 = User::factory()->create();
        $sender2 = User::factory()->create();

        Message::factory()->count(3)->create(['sender_id' => $sender1->id, 'receiver_id' => $receiver->id]);
        Message::factory()->count(2)->create(['sender_id' => $sender2->id, 'receiver_id' => $receiver->id]);

        $result = $this->service->getInbox($receiver->id);

        $this->assertCount(5, $result->items());
    }

    public function test_get_sent_messages()
    {
        $sender = User::factory()->create();
        $receiver1 = User::factory()->create();
        $receiver2 = User::factory()->create();

        Message::factory()->count(3)->create(['sender_id' => $sender->id, 'receiver_id' => $receiver1->id]);
        Message::factory()->count(2)->create(['sender_id' => $sender->id, 'receiver_id' => $receiver2->id]);

        $result = $this->service->getSentMessages($sender->id);

        $this->assertCount(5, $result->items());
    }

    public function test_get_message_details()
    {
        $message = Message::factory()->create();

        $result = $this->service->getMessageDetails($message->id);

        $this->assertEquals($message->id, $result->id);
    }

    public function test_delete_message_by_sender()
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        $message = Message::factory()->create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
        ]);

        $this->service->deleteMessage($message->id, $sender->id);

        $this->assertNull(Message::find($message->id));
    }

    public function test_delete_message_by_receiver()
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        $message = Message::factory()->create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
        ]);

        $this->service->deleteMessage($message->id, $receiver->id);

        $this->assertNull(Message::find($message->id));
    }

    public function test_delete_message_throws_exception_for_unauthorized()
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();
        $unauthorized = User::factory()->create();

        $message = Message::factory()->create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
        ]);

        $this->expectException(\Exception::class);
        $this->service->deleteMessage($message->id, $unauthorized->id);
    }

    public function test_get_recent_conversations()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        Message::factory()->create(['sender_id' => $user1->id, 'receiver_id' => $user2->id]);
        Message::factory()->create(['sender_id' => $user1->id, 'receiver_id' => $user3->id]);

        $conversations = $this->service->getRecentConversations($user1->id);

        $this->assertGreaterThan(0, count($conversations));
    }

    public function test_count_unread_messages()
    {
        $receiver = User::factory()->create();
        $sender1 = User::factory()->create();
        $sender2 = User::factory()->create();

        Message::factory()->count(3)->create(['sender_id' => $sender1->id, 'receiver_id' => $receiver->id]);
        Message::factory()->count(2)->create(['sender_id' => $sender2->id, 'receiver_id' => $receiver->id]);

        $count = $this->service->countUnreadMessages($receiver->id);

        $this->assertEquals(5, $count);
    }
}
