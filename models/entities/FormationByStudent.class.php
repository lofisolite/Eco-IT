<?php

class FormationByStudent
{
    private int $studentId;
    private int $formationId;
    private string $status;
    private int $progression;

    public function __construct(int $studentId, int $formationId, string $status, int $progression){
        $this -> studentId = $studentId;
        $this -> formationId = $formationId;
        $this -> status = $status;
        $this -> progression = $progression;
    }

    public function getStudentId(){ return $this-> studentId; }

    public function getFormationId(){ return $this -> formationId; }

    public function getStatus(){ return $this -> status; }

    public function getProgression(){ return $this-> progression; }

}