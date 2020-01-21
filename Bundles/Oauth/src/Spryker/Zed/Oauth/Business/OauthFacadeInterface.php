<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Oauth\Business;

use Generated\Shared\Transfer\OauthAccessTokenValidationRequestTransfer;
use Generated\Shared\Transfer\OauthAccessTokenValidationResponseTransfer;
use Generated\Shared\Transfer\OauthClientTransfer;
use Generated\Shared\Transfer\OauthRequestTransfer;
use Generated\Shared\Transfer\OauthResponseTransfer;
use Generated\Shared\Transfer\OauthScopeTransfer;
use Generated\Shared\Transfer\RevokeRefreshTokenRequestTransfer;
use Generated\Shared\Transfer\RevokeRefreshTokenResponseTransfer;

/**
 * @method \Spryker\Zed\Oauth\Business\OauthBusinessFactory getFactory()
 */
interface OauthFacadeInterface
{
    /**
     * Specification:
     *  - Process token request
     *  - Returns new access token when user provider return valid user
     *  - Executes scope plugins
     *  - Executes user plugins
     *  - Saves issues access token in database for auditing
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OauthRequestTransfer $oauthRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OauthResponseTransfer
     */
    public function processAccessTokenRequest(OauthRequestTransfer $oauthRequestTransfer): OauthResponseTransfer;

    /**
     * Specification:
     *  - Validates access JWT token against signature and token
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OauthAccessTokenValidationRequestTransfer $authAccessTokenValidationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OauthAccessTokenValidationResponseTransfer
     */
    public function validateAccessToken(OauthAccessTokenValidationRequestTransfer $authAccessTokenValidationRequestTransfer): OauthAccessTokenValidationResponseTransfer;

    /**
     * Specification:
     *  - Creates new scope in database
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OauthScopeTransfer $oauthScopeTransfer
     *
     * @return \Generated\Shared\Transfer\OauthScopeTransfer
     */
    public function saveScope(OauthScopeTransfer $oauthScopeTransfer): OauthScopeTransfer;

    /**
     * Specification:
     * - Creates new client in database
     *
     * @api
     *
     * @deprecated Will be removed in the next major.
     *
     * @param \Generated\Shared\Transfer\OauthClientTransfer $oauthClientTransfer
     *
     * @return \Generated\Shared\Transfer\OauthClientTransfer
     */
    public function saveClient(OauthClientTransfer $oauthClientTransfer): OauthClientTransfer;

    /**
     * Specification:
     * - Retrieves a oauth scope using the identifier within the provided transfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OauthScopeTransfer $oauthScopeTransfer
     *
     * @return \Generated\Shared\Transfer\OauthScopeTransfer|null
     */
    public function findScopeByIdentifier(OauthScopeTransfer $oauthScopeTransfer): ?OauthScopeTransfer;

    /**
     * Specification:
     * - Retrieves a oauth client using the identifier within the provided transfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OauthClientTransfer $oauthClientTransfer
     *
     * @return \Generated\Shared\Transfer\OauthClientTransfer|null
     */
    public function findClientByIdentifier(OauthClientTransfer $oauthClientTransfer): ?OauthClientTransfer;

    /**
     * Specification:
     * - Retrieves a oauth scopes using the identifiers.
     *
     * @api
     *
     * @param string[] $customerScopes
     *
     * @return \Generated\Shared\Transfer\OauthScopeTransfer[]
     */
    public function getScopesByIdentifiers(array $customerScopes): array;

    /**
     * Specification:
     * - Installs oauth client data.
     *
     * @api
     *
     * @return void
     */
    public function installOauthClient(): void;

    /**
     * Specification:
     *  - Revokes concrete refresh token.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RevokeRefreshTokenRequestTransfer $refreshToken
     *
     * @return \Generated\Shared\Transfer\RevokeRefreshTokenResponseTransfer
     */
    public function revokeConcreteRefreshToken(RevokeRefreshTokenRequestTransfer $refreshToken): RevokeRefreshTokenResponseTransfer;

    /**
     * Specification:
     *  - Revokes a refresh tokens by customer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RevokeRefreshTokenRequestTransfer $refreshToken
     *
     * @return \Generated\Shared\Transfer\RevokeRefreshTokenResponseTransfer
     */
    public function revokeRefreshTokensByCustomer(RevokeRefreshTokenRequestTransfer $refreshToken): RevokeRefreshTokenResponseTransfer;
}
