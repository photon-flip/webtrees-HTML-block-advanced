<?php

/**
 * HtmlAdvancedModule.
 */

declare(strict_types=1);

namespace HtmlBlockAdvanced;

use Fisharebest\Localization\Translation;
use Fisharebest\Webtrees\Module\HtmlBlockModule;
use Fisharebest\Webtrees\Module\ModuleCustomInterface;
use Fisharebest\Webtrees\Module\ModuleCustomTrait;
use Fisharebest\Webtrees\Module\ModuleGlobalInterface;
use Fisharebest\Webtrees\Module\ModuleGlobalTrait;

use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Services\HtmlService;
use Fisharebest\Webtrees\Tree;
use Fisharebest\Webtrees\Validator;
use Psr\Http\Message\ServerRequestInterface;
use Fisharebest\Webtrees\View;

use function in_array;
use function time;

class HtmlAdvancedModule extends HtmlBlockModule implements ModuleCustomInterface, ModuleGlobalInterface
{
   
    use ModuleCustomTrait;
    use ModuleGlobalTrait;

    public const CUSTOM_MODULE           = 'webtrees-HTML-block-advanced';
    public const CUSTOM_GITHUB_USER      = 'photon-flip';
    public const CUSTOM_WEBSITE          = 'https://github.com/' . self::CUSTOM_GITHUB_USER . '/' . self::CUSTOM_MODULE . '/';
           
    private HtmlService $html_service;

    /**
     * HtmlBlockModule bootstrap.
     *
     * @param HtmlService $html_service
     */
    
   public function __construct(HtmlService $html_service)
    {        
      parent::__construct($html_service);  
      $this->html_service = $html_service;
    }     
    
    public function resourcesFolder(): string
    {
        return __DIR__ .  DIRECTORY_SEPARATOR .  'resources' .  DIRECTORY_SEPARATOR;
        
    }
    
    /**
     * Bootstrap.  This function is called on *enabled* modules.
     * It is a good place to register routes and views.
     * Note that it is only called on genealogy pages - not on admin pages.
     *
     * @return void
     */
    public function boot(): void
    {
        View::registerNamespace($this->name(), $this->resourcesFolder() . 'views/');       
        View::registerCustomView('::html/compact-sampler', $this->name() . '::html/compact-sampler');
        View::registerCustomView('::html/compact-vanilla', $this->name() . '::html/compact-vanilla');
        View::registerCustomView('::html/config', $this->name() . '::html/config');        
        
    }        
    
    /**
     * Raw content, to be added at the end of the <head> element.
     * Typically, this will be <link> and <meta> elements.
     *
     * @return string
     */
    public function headContent(): string
    {
        return '<link rel="stylesheet" href="' . e($this->assetUrl('css/advanced.css')) . '">';       
        
    }
     
    /**
     * How should this module be identified in the control panel, etc.?
     *
     * @return string
     */
    public function title(): string
    {
        /* I18N: Name of a module */
        return I18N::translate('HTML Advanced');
    }

    /**
     * A sentence describing what this module does.
     *
     * @return string
     */
    public function description(): string
    {        
        return I18N::translate('An advanced HTML Block');
        
    }
   
    /**
     * The person or organisation who created this module.
     *
     * @return string
     */
    public function customModuleAuthorName(): string
    {
        return 'MurrayJ';
    }
    
   /**
     * Where to get support for this module.  Perhaps a github respository?
     *
     * @return string
     */
    public function customModuleSupportUrl(): string
    {
        return self::CUSTOM_WEBSITE;
    }
    
    /**
     * Should this block load asynchronously using AJAX?
     *
     * Simple blocks are faster in-line, more complex ones can be loaded later.
     *
     * @return bool
     */
    public function loadAjax(): bool
    {
        return false;
    }   

    /**
     * Can this block be shown on the user’s home page?
     *
     * @return bool
     */
    public function isUserBlock(): bool
    {
        return true;
    }

    /**
     * Can this block be shown on the tree’s home page?
     *
     * @return bool
     */
    public function isTreeBlock(): bool
    {
        return true;
    }
    
    public function customModuleVersion(): string
    {
        return '2.2.1';
    }
       
    /**
     * Update the configuration for a block.
     *
     * @param ServerRequestInterface $request
     * @param int                    $block_id
     *
     * @return void
     */
    public function saveBlockConfiguration(ServerRequestInterface $request, int $block_id): void
    {
        $title          = Validator::parsedBody($request)->string('title');
        $html           = Validator::parsedBody($request)->string('html');
        $show_timestamp = Validator::parsedBody($request)->boolean('show_timestamp');
        $languages      = Validator::parsedBody($request)->array('languages');         
        
        $this->setBlockSetting($block_id, 'title', $title);
        $this->setBlockSetting($block_id, 'html', $this->html_service->sanitize($html));
        $this->setBlockSetting($block_id, 'show_timestamp', (string) $show_timestamp);
        $this->setBlockSetting($block_id, 'timestamp', (string) time());
        $this->setBlockSetting($block_id, 'languages', implode(',', $languages));            
    }
    
    
    public function editBlockConfiguration(Tree $tree, int $block_id): string
    {
        $title          = $this->getBlockSetting($block_id, 'title');
        $html           = $this->getBlockSetting($block_id, 'html');
        $show_timestamp = $this->getBlockSetting($block_id, 'show_timestamp', '0');
        $languages      = explode(',', $this->getBlockSetting($block_id, 'languages'));  
                
        $templates = [
            $html => I18N::translate('Choose a Template from the dropdown - Warning! Overwrites custom content.'),         view('html/compact-sampler', ['tree' => $tree])   => I18N::translate('Compact Sampler'),   
            view('html/compact-vanilla', ['tree' => $tree])   => I18N::translate('Compact Vanilla'),            
        ];

        return view('html/config', [
            'html'           => $html,
            'languages'      => $languages,
            'show_timestamp' => $show_timestamp,
            'templates'      => $templates,
            'title'          => $title,              
        ]);
    }
    
    
    public function bodyContent(): string
    {
        $bodyContent = '<script src="' . $this->assetUrl('js/script.js') .'"></script>';
        return $bodyContent;
    }
 
     /** 
     * Additional/updated translations. 
     * 
     * @param string $language 
     * 
     * @return string[] // array<string,string> 
     */ 
    public  function  customTranslations ( string  $language ) :  array 
    {        
        $languageDirectory  =  $this -> resourcesFolder ()  .  'lang/' ; 
        $file               =  $languageDirectory  .  $language  .  '.mo' ; 
        if  ( file_exists ( $file ))  { 
            return  ( new  Translation ( $file )) -> asArray (); 
        }  else  { 
            return  [];            
        }         
    }    
}
