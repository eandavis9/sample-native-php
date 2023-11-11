<?php

class News
{
	private $id, $title, $body, $createdAt;

	public function __construct($id, $title, $body, $created_at)
	{
		$this->id = $id;
		$this->title = $title;
		$this->body = $body;
		$this->createdAt = $created_at;
	}

	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setBody($body)
	{
		$this->body = $body;

		return $this;
	}

	public function getBody()
	{
		return $this->body;
	}

	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}
}