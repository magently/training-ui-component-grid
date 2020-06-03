<?php

namespace Magently\MyUiComponent\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @var SchemaSetupInterface
     */
    private $setup;

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->setup = $setup;
        $this->setup->startSetup();

        if (version_compare($context->getVersion(), '0.1.1') < 0) {
            $connection = $setup->getConnection();
            $tableName = $this->setup->getTable('my_products');

            if ($connection->isTableExists($tableName)) {
                // Add FULLTEXT index for search by keyword
                $connection->addIndex(
                    $tableName,
                    $this->setup->getIdxName(
                        $tableName,
                        ['name', 'description']
                    ),
                    ['name', 'description'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                );
            }
        }

        $this->setup->endSetup();
    }
}
