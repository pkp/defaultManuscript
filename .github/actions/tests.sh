#!/bin/bash

set -e
npx cypress run --spec "cypress/tests/data/10-ApplicationSetup/10-Installation.cy.js,cypress/tests/data/10-ApplicationSetup/20-CreateContext.cy.js"
npx cypress run  --headless --browser chrome  --config '{"specPattern":["plugins/generic/customBlockManager/cypress/tests/functional/*.cy.js"]}'


