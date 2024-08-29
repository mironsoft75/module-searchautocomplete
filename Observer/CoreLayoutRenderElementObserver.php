<?php
namespace Coditron\SearchAutoComplete\Observer;

use Magento\Framework\Event\ObserverInterface;

class CoreLayoutRenderElementObserver implements ObserverInterface
{
    /**
     * @var \Coditron\SearchAutoComplete\Helper\Data
     */
    protected $helper;

    /**
     * @param \Coditron\SearchAutoComplete\Helper\Data $helper
     */
    public function __construct(\Coditron\SearchAutoComplete\Helper\Data $helper)
    {
        $this->helper = $helper;
    }
    
    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return self
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if (!$this->helper->isEnabled()) {
            return $this;
        }

        $elementName = $observer->getData('element_name');

        if ($elementName != 'top.search') {
            return $this;
        }

        $transport = $observer->getData('transport');
        $html = $transport->getOutput();
        $html = preg_replace('/<(div)\b([^>]*?)(id=("|\')search_autocomplete("|\'))([^>]*?)>(.*?)<\/div>/', '', $html, 1);

        $transport->setOutput($html);

        return $this;
    }
}