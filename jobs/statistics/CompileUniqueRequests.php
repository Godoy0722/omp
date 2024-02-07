<?php

/**
 * @file jobs/statistics/CompileUniqueRequests.php
 *
 * Copyright (c) 2024 Simon Fraser University
 * Copyright (c) 2024 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class CompileUniqueRequests
 *
 * @ingroup jobs
 *
 * @brief Compile unique requests according to COUNTER guidelines.
 */

namespace APP\jobs\statistics;

use APP\statistics\TemporaryItemRequestsDAO;
use APP\statistics\TemporaryTitleRequestsDAO;
use PKP\db\DAORegistry;
use PKP\jobs\BaseJob;

class CompileUniqueRequests extends BaseJob
{
    /**
     * The number of times the job may be attempted.
     */
    public $tries = 1;

    /**
     * The load ID = usage stats log file name
     */
    protected string $loadId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $loadId)
    {
        parent::__construct();
        $this->loadId = $loadId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $temporaryItemRequestsDao = DAORegistry::getDAO('TemporaryItemRequestsDAO'); /** @var TemporaryItemRequestsDAO $temporaryItemRequestsDao */
        $temporaryTitleRequestsDao = DAORegistry::getDAO('TemporaryTitleRequestsDAO'); /** @var TemporaryTitleRequestsDAO $temporaryTitleRequestsDao */
        $temporaryItemRequestsDao->compileBookItemUniqueClicks($this->loadId);
        $temporaryItemRequestsDao->compileChapterItemUniqueClicks($this->loadId);
        $temporaryTitleRequestsDao->compileTitleUniqueClicks($this->loadId);
    }
}
