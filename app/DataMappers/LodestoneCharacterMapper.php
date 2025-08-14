<?php

namespace App\DataMappers;

use App\Http\Resources\OccultDataResource;
use App\Models\Character;
use App\Models\OccultData;
use App\Models\PhantomJob;

class LodestoneCharacterMapper {

    private array $character;
    private array $classjobs;
    public function __construct(array $response_data){
        $this->character = data_get($response_data, 'Character', null);
        $this->classjobs = data_get($response_data, 'ClassJobs', null);
    }

    /**
     * @return array
     */
    public function getCharacterModelData(): array
    {
        return [
            'lodestone_id' => data_get($this->character, 'ID'),
            'name'         => data_get($this->character, 'Name', ''),
            'world'        => data_get($this->character, 'World', ''),
            'datacenter'   => data_get($this->character, 'DC', ''),
            'avatar_url'   => data_get($this->character, 'Avatar', ''),
            'bio'          => data_get($this->character, 'Bio', ''),
        ];
    }

    /**
     * Map the Pivot Data for Phantom Jobs, takes in an Array formatted as Key-> Name ; Value -> ID
     * @param array<string, string> $phantom_jobs
     * @return array<string, array>|null
     */
    public function getPhantomJobPivotData(array $phantom_jobs): array|null
    {
        $pjList = data_get($this->classjobs, 'PhantomJobs.List', null);
        if (!is_array($pjList)) {
            return null;
        }
        $data = [];
        foreach($pjList as $job){
            $phantomJobDatabaseID = $phantom_jobs[$job['Name']];
            $data[$phantomJobDatabaseID] = [
                'level'       => (int) data_get($job, 'Level', 0),
                'current_xp'  => (int) data_get($job, 'CurrentEXP', 0),
                'max_xp'      => (int) data_get($job, 'MaxEXP', 0),
                'mastered'    => data_get($job, 'Mastered', null) != null,
            ];
        }
        return count($data) > 0 ? $data : null;
    }

    /**
     * @return array|null
     */
    public function getOccultModelData(): array|null
    {
        $ocData = data_get($this->classjobs, 'OccultCrescent', null);
        $pjList = data_get($this->classjobs, 'PhantomJobs.List', null);
        if (!is_array($ocData) || !is_array($pjList)) {
            return null;
        }
        return [
            'knowledge_level' => (int) data_get($ocData, 'Level', 0),
            'phantom_mastery' => self::computeMastery($pjList),
            'phantom_jobs'    => json_encode($pjList)
        ];
    }

    private static function computeMastery(array $phantom_jobs): int
    {
        $mastery = 0;
        foreach($phantom_jobs as $phantom_job){
            if(data_get($phantom_job, 'Mastered') === 'MASTERED'){
                $mastery++;
            }
        }
        return $mastery;
    }
}
