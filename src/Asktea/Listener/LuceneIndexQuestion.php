<?php

namespace Asktea\Listener;

class LuceneIndexQuestion extends Common
{
	protected $indexer;

    public function __construct(\Asktea\Lib\LuceneQuestionIndexer $indexer)
    {
        $this->indexer = $indexer;
    }

	public function update($oQuestion)
	{
		if (!$oQuestion instanceof \Asktea\Model\Question)
		{
			throw new \InvalidArgumentException('LuceneIndexQuestion->update method only accepts \Asktea\Model\Question object.');
		}

		$this->indexer->update($oQuestion->id, $oQuestion->title, $oQuestion->body);
	}
}