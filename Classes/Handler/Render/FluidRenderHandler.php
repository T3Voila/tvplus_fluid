<?php

declare(strict_types=1);

namespace T3voila\TvplusFluid\Handler\Render;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Tvp\TemplaVoilaPlus\Domain\Model\Configuration\TemplateConfiguration;
use Tvp\TemplaVoilaPlus\Handler\Render\RenderHandlerInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class FluidRenderHandler implements RenderHandlerInterface
{
    public static $identifier = 'TVP\Renderer\Fluid';

    public function renderTemplate(TemplateConfiguration $templateConfiguration, array $processedValues, array $row): string
    {
        /** @var StandaloneView */
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $path = GeneralUtility::getFileAbsFileName($templateConfiguration->getPlace()->getEntryPoint());
        $options = $templateConfiguration->getOptions();

        /** @TODO Check if template file otherwise bad error messages will happen */
        $view->setTemplatePathAndFilename(GeneralUtility::getFileAbsFileName($templateConfiguration->getTemplateFileName()));

        if (isset($options['layoutRootPaths'])) {
            $view->setLayoutRootPaths($options['layoutRootPaths']);
        }
        if (isset($options['partialRootPaths'])) {
            $view->setPartialRootPaths($options['partialRootPaths']);
        }

        /** @TODO process remapping instructions before */
        $view->assignMultiple($processedValues);
        $view->assign('data', $row);

        try {
            return $view->render() ?? '';
        } catch (\Exception $e) {
            /** @TODO Error message */
            return $e->getMessage();
        }
        return '';
    }

    /**
     * @TODO Move this in an AbstractRenderHandler class
     */
    public function processHeaderInformation(TemplateConfiguration $templateConfiguration)
    {
        $headerConfiguration = $templateConfiguration->getHeader();

        /** @var \TYPO3\CMS\Core\Page\PageRenderer */
        $pageRenderer = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);

        // Meta
        if (isset($headerConfiguration['meta']) && is_array($headerConfiguration['meta'])) {
            foreach ($headerConfiguration['meta'] as $metaName => $metaConfiguration) {
                if (version_compare(TYPO3_version, '9.3.0', '>=')) {
                    $pageRenderer->setMetaTag('name', $metaName, $metaConfiguration['content']);
                } else {
                    $pageRenderer->addMetaTag('<meta name="' . $metaName . '" content="' . $metaConfiguration['content'] . '">');
                }
            }
        }

        // CSS
        if (isset($headerConfiguration['css']) && is_array($headerConfiguration['css'])) {
            foreach ($headerConfiguration['css'] as $cssConfiguration) {
                $pageRenderer->addCssFile($cssConfiguration['href'], $cssConfiguration['rel'], $cssConfiguration['media']);
            }
        }
        // Javascript
        if (isset($headerConfiguration['javascript']) && is_array($headerConfiguration['javascript'])) {
            foreach ($headerConfiguration['javascript'] as $jsConfiguration) {
                $pageRenderer->addJsFile($jsConfiguration['src']);
            }
        }
    }
}
