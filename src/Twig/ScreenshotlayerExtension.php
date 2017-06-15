<?php

namespace AppBundle\Twig;

/**
 * Twig extension using the screenshotlayer API to display website screenshot. Requires a valid API key.
 */
class ScreenshotlayerExtension extends \Twig_Extension
{
    /**
     * @var string
     */
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('screenshotlayer', [$this, 'screenshotlayerFilter'], ['is_safe' => ['html']]),
        );
    }

    public function screenshotlayerFilter(string $link, $width = 450, $fullHeightCapture = 0) : string
    {
        $thumbnailHtml = '<a href="$1" target="_blank"><img src="http://api.screenshotlayer.com/api/capture?access_key=' . $this->apiKey . '&url=$1&fullpage=' . $fullHeightCapture . '&viewport=1440x900&width=' . $width . '" /></a> ';

        return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_,\.#%-]*(\?\S+)?[^\.\s])?)?)@', $thumbnailHtml, $link);
    }

    public function getName() : string
    {
        return 'screenshotlayer';
    }
}
