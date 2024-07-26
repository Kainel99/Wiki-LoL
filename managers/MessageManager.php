<?php 

class MessageManager extends AbstractManager 
{
     public function getAllMessages()
    {
        $query = "SELECT * FROM messages";
        $results = $this->fetchResults($query);

        $messages = [];
        foreach ($results as $result) {
            $messages[] = $this->mapToMessage($result);
        }

        return $messages;
    }

    public function getMessageById($id)
    {
        $query = "SELECT * FROM messages WHERE id = :id";
        $parameters = [':id' => $id];
        $results = $this->fetchResults($query, $parameters);

        if (count($results) > 0) {
            return $this->mapToMessage($results[0]);
        }

        return null;
    }

    public function createMessage($content)
    {
        $query = "INSERT INTO messages (content, timestamp) VALUES (:content, :timestamp)";
        $parameters = [
            ':content' => $content,
            ':timestamp' => date('Y-m-d H:i:s')
        ];
        $this->executeQuery($query, $parameters);
    }

    public function updateMessage($id, $content)
    {
        $query = "UPDATE messages SET content = :content WHERE id = :id";
        $parameters = [
            ':content' => $content,
            ':id' => $id
        ];
        $this->executeQuery($query, $parameters);
    }

    public function deleteMessage($id)
    {
        $query = "DELETE FROM messages WHERE id = :id";
        $parameters = [':id' => $id];
        $this->executeQuery($query, $parameters);
    }

    private function mapToMessage($data)
    {
        $message = new Message();
        $message->setId($data['id']);
        $message->setContent($data['content']);
        $message->setTimestamp($data['timestamp']);

        return $message;
    }
}