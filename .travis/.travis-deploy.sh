#!/bin/bash

# Inspired by: https://stackoverflow.com/questions/31338562/travisci-run-after-success-on-a-specific-branch

# PLEASE NOTE: A failure here will not fail the build.

echo "TRAVIS_BRANCH: \"$TRAVIS_BRANCH\"" ;

DEPLOY_WEBHOOK_URL="https://envoyer.io/deploy/xNDFwCJdWVATPYkQdMZUfTZSWoq7WCcGyQO3gaeC";

SUCCESS_CODE=0;

if [ "$TRAVIS_BRANCH" == "master" ] ; then
echo "DEPLOYING: \"$DEPLOY_WEBHOOK_URL\"" ;
 curl --silent "$DEPLOY_WEBHOOK_URL" ;
  SUCCESS_CODE=$?;
else
  SUCCESS_CODE=0;
fi

echo "Deploy SUCCESS_CODE: \"$SUCCESS_CODE\"" ;

exit $SUCCESS_CODE ;