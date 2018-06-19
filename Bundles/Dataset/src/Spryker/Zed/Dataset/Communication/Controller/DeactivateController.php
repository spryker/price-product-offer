<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Dataset\Communication\Controller;

use Generated\Shared\Transfer\DatasetTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\Dataset\Business\DatasetFacade getFacade()
 * @method \Spryker\Zed\Dataset\Communication\DatasetCommunicationFactory getFactory()
 */

class DeactivateController extends AbstractController
{
    public const URL_PARAM_ID_DATASET = 'id-dataset';
    public const URL_PARAM_REDIRECT_URL = 'redirect-url';
    public const REDIRECT_URL_DEFAULT = '/dataset';
    public const REFERER_PARAM = 'referer';
    public const MESSAGE_DATASET_DEACTIVATE_SUCCESS = 'Dataset was deactivated successfully.';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request): RedirectResponse
    {
        $idDataset = $this->castId($request->query->get(static::URL_PARAM_ID_DATASET));
        $redirectUrl = $request->query->get(static::URL_PARAM_REDIRECT_URL, static::REDIRECT_URL_DEFAULT);
        $this->getFacade()->activateDataset((new DatasetTransfer())->setIdDataset($idDataset)->setIsActive(false));
        $this->addSuccessMessage(static::MESSAGE_DATASET_DEACTIVATE_SUCCESS);

        return $this->redirectResponse($redirectUrl);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirectBack(Request $request): RedirectResponse
    {
        $referer = $request->headers->get(static::REFERER_PARAM);

        return $this->redirectResponse($referer);
    }
}
