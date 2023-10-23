/**
 * @file cypress/tests/functional/defaultManuscript.cy.js
 *
 * Copyright (c) 2014-2020 Simon Fraser University
 * Copyright (c) 2000-2020 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file LICENSE.
 *
 */

describe("Theme plugin tests", function () {
  it("Enables and selects the theme", function () {
    cy.login("admin", "admin", "publicknowledge");

    cy.get('a:contains("Website")').click();
    cy.get('button[id="plugins-button"]').click();

    // Find and enable the plugin
    cy.get(
      'input[id^="select-cell-defaultmanuscriptchildthemeplugin-enabled"]'
    ).click();
    cy.get(
      "div:contains('The plugin \"Manuscript (Default child theme)\" has been enabled.')"
    );

    // Appearance tab does not get updated until the reload
    cy.reload();

    // Select the new theme
    cy.get('button[id="appearance-button"]').click();
    cy.get('select[id="theme-themePluginPath-control"]').select(
      "Manuscript (Default child theme)"
    );

    cy.get('#theme button:contains("Save")').click();
  });

  it("Views the theme", function () {
    cy.visit("/");
    cy.get(".pkp_site_name .is_text").should(
      "have.css",
      "text-transform",
      "uppercase"
    );
  });
});
