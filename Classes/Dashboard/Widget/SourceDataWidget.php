<?php

declare(strict_types=1);

/*
 * This file is part of the plausibleio extension for TYPO3
 * - (c) 2021 waldhacker UG (haftungsbeschränkt)
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Waldhacker\Plausibleio\Dashboard\Widget;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Dashboard\Widgets\AdditionalCssInterface;
use TYPO3\CMS\Dashboard\Widgets\RequireJsModuleInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetConfigurationInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;
use Waldhacker\Plausibleio\Dashboard\DataProvider\SourceDataProvider;
use Waldhacker\Plausibleio\Services\ConfigurationService;
use Waldhacker\Plausibleio\Services\PlausibleService;

class SourceDataWidget implements WidgetInterface, AdditionalCssInterface, RequireJsModuleInterface
{
    private PageRenderer $pageRenderer;
    private WidgetConfigurationInterface $configuration;
    private PlausibleService $plausibleService;
    private StandaloneView $view;
    private array $options;

    private SourceDataProvider $dataProvider;
    private ConfigurationService $configurationService;

    public function __construct(
        PageRenderer $pageRenderer,
        WidgetConfigurationInterface $configuration,
        PlausibleService $plausibleService,
        SourceDataProvider $dataProvider,
        StandaloneView $view,
        ConfigurationService $configurationService,
        array $options = []
    ) {
        $this->pageRenderer = $pageRenderer;
        $this->configuration = $configuration;
        $this->plausibleService = $plausibleService;
        $this->view = $view;
        $this->options = $options;
        $this->dataProvider = $dataProvider;
        $this->configurationService = $configurationService;
        $this->preparePageRenderer();
    }

    public function renderWidgetContent(): string
    {
        $timeSelectorConfig = [
            'items' => $this->configurationService->getTimeFrames(),
            'selected' => $this->configurationService->getDefaultTimeFrameValue(),
        ];

        $tabsData = [
            [
                'label' => 'All',
                'id' => 'allsources',
            ],
            [
                'label' => 'Medium',
                'id' => 'mediumsource',
            ],
            [
                'label' => 'Source',
                'id' => 'sourcesource',
            ],
            [
                'label' => 'Campaign',
                'id' => 'campaignsource',
            ],
        ];

        $this->view->setTemplate('BaseTabs');
        $this->view->assignMultiple([
            'widgetType' => 'sourceChart',
            'timeSelectorConfig' => $timeSelectorConfig,
            'tabs' => $tabsData,
            'id' => $this->plausibleService->getRandomId('plausibleWidgteTab'),
            'options' => $this->options,
            'configuration' => $this->configuration,
            'label' => 'plausible.sourceData.label',
            'validConfiguration' => $this->configurationService->isValidConfiguration(),
        ]);

        return $this->view->render();
    }

    public function getCssFiles(): array
    {
        return [
            'EXT:plausibleio/Resources/Public/Css/widget.css',
        ];
    }

    public function getRequireJsModules(): array
    {
        return [
            'TYPO3/CMS/Plausibleio/Contrib/d3-format',
            'TYPO3/CMS/Plausibleio/SourceLoader',
            'TYPO3/CMS/Plausibleio/PlausibleWidgets',
        ];
    }

    private function preparePageRenderer(): void
    {
        $this->pageRenderer->addRequireJsConfiguration(
            [
                'shim' => [
                    'TYPO3/CMS/Dashboard/WidgetContentCollector' => [
                        'deps' => [
                            'TYPO3/CMS/Plausibleio/PlausibleWidgets',
                            'TYPO3/CMS/Plausibleio/SourceLoader',
                        ],
                    ],
                ],
            ]
        );
    }
}
