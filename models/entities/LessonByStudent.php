<?php

class LessonByStudent
{
    private int $studentId;
    private int $lessonId;
    private int $formationId;
    private string $status;

    public function __construct(int $studentId, int $lessonId, int $formationId, string $status){
        $this -> studentId = $studentId;
        $this -> lessonId = $lessonId;
        $this -> formationId = $formationId;
        $this -> status = $status;
    }

    public function getStudentId(){ return $this -> studentId; }

    public function getLessonId(){ return $this -> lessonId; }

    public function getFormationId(){ return $this -> formationId; }

    public function getStatus(){ return $this -> status; }

}