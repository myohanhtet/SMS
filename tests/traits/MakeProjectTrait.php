<?php

use App\Models\Project;
use App\Repositories\ProjectRepository;
use Faker\Factory as Faker;

trait MakeProjectTrait
{
    /**
     * Create fake instance of Project and save it in database
     *
     * @param array $projectFields
     * @return Project
     */
    public function makeProject($projectFields = [])
    {
        /** @var ProjectRepository $projectRepo */
        $projectRepo = App::make(ProjectRepository::class);
        $theme = $this->fakeProjectData($projectFields);
        return $projectRepo->create($theme);
    }

    /**
     * Get fake instance of Project
     *
     * @param array $projectFields
     * @return Project
     */
    public function fakeProject($projectFields = [])
    {
        return new Project($this->fakeProjectData($projectFields));
    }

    /**
     * Get fake data of Project
     *
     * @param array $postFields
     * @return array
     */
    public function fakeProjectData($projectFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'project' => $fake->word,
            'type' => $fake->word,
            'sections' => $fake->text,
            'dblink' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word,
        ], $projectFields);
    }
}
