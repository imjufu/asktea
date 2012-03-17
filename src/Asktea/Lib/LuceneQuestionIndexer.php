<?php

namespace Asktea\Lib;

class LuceneQuestionIndexer
{
    protected 
        $index,
        $question;

    public function __construct(\Zend\Search\Lucene\Index $index)
    {
        $this->index = $index;
    }

    public function update($id, $title, $body)
    {
        $this->question = array(
            'id'    => $id,
            'title' => $title,
            'body'  => $body
        );
        
        $this
            ->remove()
            ->add()
            ->commit();
    }

    protected function remove()
    {
        // remove an existing entry
        if ($hit = $this->index->find('pk:'.$this->question['id']))
        {
            $this->index->delete($hit->id);
        }

        return $this;
    }

    protected function add()
    {
        $document = new \Zend\Search\Lucene\Document();

        // store job primary key URL to identify it in the search results
        $document->addField(\Zend\Search\Lucene\Document\Field::UnIndexed('pk', $this->question['id']));

        // index job fields
        $document->addField(\Zend\Search\Lucene\Document\Field::UnStored('title', $this->question['title'], 'utf-8'));
        $document->addField(\Zend\Search\Lucene\Document\Field::UnStored('body', $this->question['body'], 'utf-8'));

        // add job to the index
        $this->index->addDocument($document);

        return $this;
    }

    protected function commit()
    {
        $this->index->commit();
    }
}