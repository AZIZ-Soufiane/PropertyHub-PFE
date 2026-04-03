<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class PropertyHubApiService
{
    private string $baseUrl;
    private string $token;

    public function __construct()
    {
        // Use localhost for development, change for production
        $this->baseUrl = env('PROPERTY_HUB_API_URL', 'http://localhost:8000/api');
        $this->token = session('api_token', '');
    }

    /**
     * Set the authentication token
     */
    public function setToken(string $token): self
    {
        $this->token = $token;
        session(['api_token' => $token]);
        return $this;
    }

    /**
     * Make HTTP request with authentication
     */
    private function request(string $method, string $endpoint, array $data = []): array
    {
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->{$method}($url, $data);

        return $response->json();
    }

    /**
     * Login to PropertyHub
     */
    public function login(string $email, string $password): array
    {
        $response = Http::post($this->baseUrl . '/auth/login', [
            'email' => $email,
            'password' => $password,
        ]);

        $data = $response->json();
        
        if (isset($data['token'])) {
            $this->setToken($data['token']);
        }

        return $data;
    }

    /**
     * Register new user
     */
    public function register(string $name, string $email, string $password, string $passwordConfirmation, string $role): array
    {
        $response = Http::post($this->baseUrl . '/auth/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
            'role' => $role,
        ]);

        $data = $response->json();

        if (isset($data['token'])) {
            $this->setToken($data['token']);
        }

        return $data;
    }

    /**
     * Get current user
     */
    public function getCurrentUser(): array
    {
        return $this->request('get', '/auth/user');
    }

    /**
     * Logout
     */
    public function logout(): array
    {
        return $this->request('post', '/auth/logout');
    }

    // ========== PROPERTIES ==========

    /**
     * Get all properties
     */
    public function getProperties(int $page = 1, int $perPage = 15, string $status = 'active'): array
    {
        return Http::get($this->baseUrl . '/properties', [
            'page' => $page,
            'per_page' => $perPage,
            'status' => $status,
        ])->json();
    }

    /**
     * Get property details
     */
    public function getPropertyDetails(int $propertyId): array
    {
        return Http::get($this->baseUrl . '/properties/' . $propertyId)->json();
    }

    /**
     * Search properties
     */
    public function searchProperties(
        ?string $location = null,
        ?int $minPrice = null,
        ?int $maxPrice = null,
        string $status = 'active',
        int $page = 1,
        int $perPage = 15
    ): array
    {
        return Http::get($this->baseUrl . '/properties/search', [
            'location' => $location,
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'status' => $status,
            'page' => $page,
            'per_page' => $perPage,
        ])->json();
    }

    /**
     * Get properties by agent
     */
    public function getPropertiesByAgent(int $agentId, int $page = 1, int $perPage = 15): array
    {
        return Http::get($this->baseUrl . '/properties/agent/' . $agentId, [
            'page' => $page,
            'per_page' => $perPage,
        ])->json();
    }

    /**
     * Add property to favorites
     */
    public function addToFavorites(int $propertyId): array
    {
        return $this->request('post', '/properties/' . $propertyId . '/favorite');
    }

    /**
     * Remove property from favorites
     */
    public function removeFromFavorites(int $propertyId): array
    {
        return $this->request('delete', '/properties/' . $propertyId . '/favorite');
    }

    /**
     * Get user's favorite properties
     */
    public function getFavorites(int $page = 1, int $perPage = 15): array
    {
        return $this->request('get', '/favorites?page=' . $page . '&per_page=' . $perPage);
    }

    /**
     * Get property statistics
     */
    public function getPropertyStatistics(): array
    {
        return $this->request('get', '/dashboard/stats');
    }

    // ========== APPOINTMENTS ==========

    /**
     * Get user's appointments
     */
    public function getAppointments(int $page = 1, int $perPage = 15, ?string $status = null): array
    {
        $url = '/appointments?page=' . $page . '&per_page=' . $perPage;
        if ($status) {
            $url .= '&status=' . $status;
        }
        return $this->request('get', $url);
    }

    /**
     * Get available slots for agent
     */
    public function getAvailableSlots(int $agentId, string $date): array
    {
        return $this->request('get', '/appointments/agent/' . $agentId . '/slots?date=' . $date);
    }

    /**
     * Book appointment
     */
    public function bookAppointment(int $agentId, string $dateTime): array
    {
        return $this->request('post', '/appointments', [
            'agent_id' => $agentId,
            'date_time' => $dateTime,
        ]);
    }

    /**
     * Cancel appointment
     */
    public function cancelAppointment(int $appointmentId): array
    {
        return $this->request('post', '/appointments/' . $appointmentId . '/cancel');
    }

    /**
     * Reschedule appointment
     */
    public function rescheduleAppointment(int $appointmentId, string $dateTime): array
    {
        return $this->request('post', '/appointments/' . $appointmentId . '/reschedule', [
            'date_time' => $dateTime,
        ]);
    }

    // ========== MESSAGES ==========

    /**
     * Get conversations
     */
    public function getConversations(int $page = 1, int $perPage = 15): array
    {
        return $this->request('get', '/messages/conversations?page=' . $page . '&per_page=' . $perPage);
    }

    /**
     * Get conversation with user
     */
    public function getConversation(int $userId, int $page = 1, int $perPage = 50): array
    {
        return $this->request('get', '/messages/conversation/' . $userId . '?page=' . $page . '&per_page=' . $perPage);
    }

    /**
     * Send message
     */
    public function sendMessage(int $receiverId, string $content): array
    {
        return $this->request('post', '/messages', [
            'receiver_id' => $receiverId,
            'content' => $content,
        ]);
    }

    /**
     * Delete message
     */
    public function deleteMessage(int $messageId): array
    {
        return $this->request('delete', '/messages/' . $messageId);
    }

    /**
     * Get inbox
     */
    public function getInbox(int $page = 1, int $perPage = 15): array
    {
        return $this->request('get', '/messages/inbox?page=' . $page . '&per_page=' . $perPage);
    }

    /**
     * Get sent messages
     */
    public function getSentMessages(int $page = 1, int $perPage = 15): array
    {
        return $this->request('get', '/messages/sent?page=' . $page . '&per_page=' . $perPage);
    }

    // ========== USERS ==========

    /**
     * Get user profile
     */
    public function getUserProfile(int $userId): array
    {
        return $this->request('get', '/users/' . $userId);
    }

    /**
     * Update user profile
     */
    public function updateProfile(array $data): array
    {
        return $this->request('post', '/users/profile', $data);
    }

    /**
     * Get all agents
     */
    public function getAgents(int $page = 1, int $perPage = 15): array
    {
        return Http::get($this->baseUrl . '/agents', [
            'page' => $page,
            'per_page' => $perPage,
        ])->json();
    }
}
