<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Message;
use App\Models\User;
use App\Services\MessageService;

class MessageServiceTest extends TestCase
{
    protected MessageService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new MessageService();
    }

    /**
     * @group mvp
     */
    public function test_send_message_using_real_db()
    {
        $sender = User::first();
        $receiver = User::where('id', '!=', $sender->id)->first();

        if (!$sender || !$receiver) {
            $this->markTestSkipped('Insufficient users in DB');
        }

        $message = $this->service->sendMessage($sender->id, $receiver->id, 'Hello Test');

        $this->assertEquals('Hello Test', $message->content);
        $this->assertEquals($sender->id, $message->sender_id);
        $this->assertEquals($receiver->id, $message->receiver_id);
        
        // Cleanup for repeatable test
        $message->delete();
    }

    /**
     * @group mvp
     */
    public function test_get_conversation_using_real_db()
    {
        $u1 = User::first();
        $u2 = User::where('id', '!=', $u1->id)->first();

        if (!$u1 || !$u2) {
             $this->markTestSkipped('Insufficient users in DB');
        }

        // Setup message
        $m = $this->service->sendMessage($u1->id, $u2->id, 'Testing conversation');

        $conv = $this->service->getConversation($u1->id, $u2->id);

        $this->assertGreaterThanOrEqual(1, $conv->total());
        
        // Cleanup
        $m->delete();
    }
}
