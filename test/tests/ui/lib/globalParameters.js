/**
 * Global configuration parameters
 * @type {GlobalParameters}
 */
module.exports = class GlobalParameters {
    static getConsumerCredentials(env, region) {

        const consumerMap = {
            prod: {
                '-au.learnosity.com': {
                    key: 'QVq9GG8YRRZiYqRR',
                    secret: 'sTNFghgVMU7eQBKqhB0yR9Wta5b9v3boXy3Dgkj2',
                    domain: 'localhost'
                },
                '.learnosity.com': {
                    key: 'QTALrtaDNIbh3msw',
                    secret: 'qHNrgFt1DH90zgkPAvl1oLFCdquhdmdT40LkGFmT',
                    domain: 'localhost'
                },
                '-or.learnosity.com' : {
                    key: 'QTALrtaDNIbh3msw',
                    secret: 'qHNrgFt1DH90zgkPAvl1oLFCdquhdmdT40LkGFmT',
                    domain: 'localhost'
                }
            },
            staging: {
                key: 'QTALrtaDNIbh3msw',
                secret: 'qHNrgFt1DH90zgkPAvl1oLFCdquhdmdT40LkGFmT',
                domain: 'localhost'
            },
            vg: {
                key: 'QTALrtaDNIbh3msw',
                secret: 'qHNrgFt1DH90zgkPAvl1oLFCdquhdmdT40LkGFmT',
                domain: 'localhost'
            },
            escrow: {
                key: 'QTALrtaDNIbh3msw',
                secret: 'qHNrgFt1DH90zgkPAvl1oLFCdquhdmdT40LkGFmT',
                domain: 'localhost'
            },
        };

        switch (env) {
            case 'prod':
                return consumerMap[env][region];
            case 'staging':
            case 'vg':
            case 'escrow':
                return consumerMap[env];
            default:
                throw new Error('No credentials found for env ' + env + ' and region ' + region);
        }
    }

    static getAuthorSiteCredentials() {

        return {
            username : 'integration-tests',
            password : 'who goes there'
        };
    }

    static getSecurityObject(env, region, userId) {

        return {
            'user_id' : userId,
            'consumer_key' : this.getConsumerCredentials(env, region).key,
            'domain' : 'localhost'
        };
    }

    static getApiSrc(api, env, region, version) {
        const apiSrc = {
            'prod' : `//${api}${region}/?${version}`,
            'staging' : `//${api}.staging.learnosity.com?${version}`,
            'vg' : `//${api}.vg.learnosity.com/?latest`,
            'escrow' : `//${api}.escrow.learnosity.com?${version}`,
        };

        return apiSrc[env];
    }

    static getDataApiSrc(api, env, region) {
        const apiSrc = {
            'prod' : `${api}${region}`,
            'staging' : `${api}.staging.learnosity.com`,
            'vg' : `${api}.vg.learnosity.com`,
            'escrow' : `${api}.escrow.learnosity.com`,
        };

        return apiSrc[env];
    }

};
