<?php

interface CrawlerInterface
{
    public function setSource($source_id);

    public function downloadNewPosts();
}