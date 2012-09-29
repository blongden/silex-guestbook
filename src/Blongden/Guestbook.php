<?php
namespace Blongden;

class Guestbook
{
    protected $filename = null;

    protected $guestbook = null;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function get()
    {
        $this->loadGuestbook();
        return $this->guestbook;
    }

    public function add($name, $message, $time)
    {
        $this->loadGuestbook();

        $this->guestbook[] = [
            'name' => $name,
            'message' => $message,
            'time' => $time
        ];

        return $this;
    }

    protected function loadGuestbook()
    {
        if (is_null($this->guestbook)) {
            $this->guestbook = [];
            if (file_exists($this->filename)) {
                $this->guestbook = json_decode(file_get_contents($this->filename, true));
            }
        }

        return true;
    }

    public function save()
    {
        return file_put_contents($this->filename, json_encode($this->guestbook));
    }
}
