<?php

declare(strict_types=1);

namespace Waldhacker\Plausibleio\Dashboard\DataProvider;

use Waldhacker\Plausibleio\Services\ConfigurationService;
use Waldhacker\Plausibleio\Services\PlausibleService;

class DeviceDataProvider
{
    private PlausibleService $plausibleService;
    private ConfigurationService $configurationService;

    public function __construct(PlausibleService $plausibleService, ConfigurationService $configurationService)
    {
        $this->plausibleService = $plausibleService;
        $this->configurationService = $configurationService;
    }

    public function getDeviceData(?string $timeFrame = null, ?string $site = null): array
    {
        return $this->plausibleService->getDeviceData(
            $timeFrame ?? $this->configurationService->getDefaultTimeFrameValue(),
            $site ?? $this->configurationService->getDefaultSite()
        );
    }
}
