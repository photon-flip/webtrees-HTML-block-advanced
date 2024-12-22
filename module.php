<?php

/**
 * HtmlAdvancedModule.
 */

declare(strict_types=1);

namespace HtmlBlockAdvanced;

use Fisharebest\Webtrees\Registry;

require __DIR__ . '/HtmlAdvancedModule.php';

return Registry::container()->get(HtmlAdvancedModule::class);
