<?php namespace KBC\Storages;

use Closure;

class JsonDatabase {

    protected $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function insert($data)
    {
        $rows = $this->readContents();
        $rows[] = $data;
        $this->writeContents($rows);
    }

    public function update($accountId, Callable $callback)
    {
        $rows = $this->readContents();
        foreach($rows as &$row)
        {
            if ($row['id'] == $accountId) {
                $row = $callback($row);
            }
        }
        $this->writeContents($rows);
    }

    /**
     * @return mixed
     */
    private function readContents()
    {
        return json_decode(file_get_contents($this->file), true);
    }

    /**
     * @param $contents
     */
    private function writeContents($contents)
    {
        file_put_contents($this->file, json_encode($contents, JSON_PRETTY_PRINT));
    }

}