<?php
namespace Modules\Job\Events;

use Illuminate\Queue\SerializesModels;

class EmployerChangeApplicantsStatus
{
    use SerializesModels;
    public $row;

    public function __construct($row)
    {
        $this->row = $row;
    }
}
