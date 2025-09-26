<?php

use MediaWiki\MediaWikiServices;

/**
 * Service wiring for PagePort
 * @codeCoverageIgnore
 */
return [
	'PagePort' => static function ( MediaWikiServices $services ): PagePort {
		$categoryLinkMigrationStage = MIGRATION_OLD;
		$config = $services->getMainConfig();
		if ( $config->has( 'CategoryLinksSchemaMigrationStage' ) ) {
			$categoryLinkMigrationStage = $config->get( 'CategoryLinksSchemaMigrationStage' );
		} elseif ( version_compare( MW_VERSION, '1.44', '>' ) ) {
			// 1.45 removed the configuration
			$categoryLinkMigrationStage = MIGRATION_NEW;
		}
		return new PagePort(
			$categoryLinkMigrationStage,
			$services->getLinksMigration(),
			$services->getContentLanguage(),
			$services->getDBLoadBalancer(),
			$services->getNamespaceInfo(),
			$services->getWikiPageFactory()
		);
	},
];
