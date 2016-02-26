<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Propel\Business;

interface PropelFacadeInterface
{

    /**
     * @api
     *
     * @return void
     */
    public function cleanPropelSchemaDirectory();

    /**
     * @api
     *
     * @return void
     */
    public function copySchemaFilesToTargetDirectory();

    /**
     * @api
     *
     * @return void
     */
    public function adjustPropelSchemaFilesForPostgresql();

    /**
     * @api
     *
     * @return void
     */
    public function adjustPostgresqlFunctions();

    /**
     * @api
     *
     * @return \Symfony\Component\Console\Command\Command[]
     */
    public function getConsoleCommands();

}
