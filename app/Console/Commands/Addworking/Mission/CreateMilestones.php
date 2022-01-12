<?php

namespace App\Console\Commands\Addworking\Mission;

use App\Models\Addworking\Mission\Milestone;
use App\Models\Addworking\Mission\Mission;
use App\Repositories\Addworking\Mission\MilestoneRepository;
use Illuminate\Console\Command;

class CreateMilestones extends Command
{
    protected $signature = 'mission:create-milestones {type}';

    protected $description = 'Create milestones for missions';

    protected $milestoneRepository;

    public function __construct(MilestoneRepository $milestoneRepository)
    {
        parent::__construct();

        $this->milestoneRepository = $milestoneRepository;
    }

    public function handle()
    {
        if (!in_array($this->argument('type'), Milestone::getAvailableMilestoneTypes())) {
            $this->error("Invalid type of milestone. Possible value [monthly]");
            return;
        }

        $missions = Mission::where('milestone_type', $this->argument('type'))->inProgress()->get();

        foreach ($missions as $mission) {
            $milestones = [];

            try {
                $milestones = $this->milestoneRepository->createFromMission($mission);
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }

            ! empty($milestones)
                ? $this->info("Milestones for the mission {$mission->id} has been created")
                : $this->error("Error when creating a milestone for the mission {$mission->id}");

            unset($mission);
            gc_collect_cycles();
        }

        $this->info("Task finished");
    }
}
