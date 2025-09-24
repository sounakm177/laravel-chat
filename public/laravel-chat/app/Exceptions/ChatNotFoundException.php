class ChatNotFoundException extends \Exception
{
    protected $message = 'Chat not found.';

    public function __construct($chatId = null)
    {
        if ($chatId) {
            $this->message = "Chat with ID {$chatId} not found.";
        }
        parent::__construct($this->message);
    }
}