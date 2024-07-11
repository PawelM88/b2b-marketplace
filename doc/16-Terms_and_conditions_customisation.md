# Terms and conditions customisation

Terms and Conditions exists in Spryker as a CMS page imported from a csv file and can be edited in the Back Office.<br>
It was placed in the footer, it does not have its own table in the database. This implementation makes the following changes:
- additional terms and conditions have been created
- two separate tables were created in the database for terms and conditions
- immediately after logging in, the terms and conditions are verified
- a form was created to accept missing or invalid consents
- a redirection system has been created in case the user does not want to accept the required consents

## Import terms and conditions

The content for the new terms has been placed in the file `data/import/common/common/cms_page.csv`<br>
Two new csv files have been created:
1) with terms - saved to the table `pyz_term`, console command to import `console data:import:terms`
2) with the allocation of terms to customers - saved to the table `pyz_term_consent`, console command to import `console data:import:terms-consent`

Due to the fact that there is no separate command for importing only CMS pages, you should run the command to import all csv files at the very beginning.
```bash
console data:import
```
Only when cms pages for terms and conditions already exist, you can use the above commands directly to import terms.

> NOTE! After data import, all customers have immediately accepted all terms and conditions.
> If you want to see the form in action, remove at least one term from the pyz_term_consent table for the selected user

## New tables in database

Two new tables have been created in the database
1) pyz_term - contains information about the terms themselves
2) pyz_term_consent - assigns specific terms to users
Schema for tables:
src/Pyz/Zed/Term/Persistence/Propel/Schema/pyz_term.schema.xml

## Terms required to accept form 

1) Right after the user logs in to Yves, his data is saved in the session. 
2) Based on this data, a query is sent to Zed whether this specific user has accepted all required consents (including those that have been updated). 
3) If all consents are OK, the login process continues. 
4) If there are consents that require acceptance, the user is redirected to a new form in which the missing terms are listed in the form of checkboxes along with links to CMS pages.
5) Here the user can:<br>
    a) accept the terms and the login process continues<br>
    b) logout<br>
    c) click on the link with term CMS Page<br>
6) Each click on any link other than Logout or links to cms pages with terms, will redirect you to the page with the form for terms.

## Redirection to terms form

The plugin `TermConsentEventDispatcherPlugin` in the CustomerPage module is responsible for redirections.

## Things TODO

In Back Office it is not possible to create new term and condition, assign a cms page to it and save it in the database. This is a completely separate functionality that needs to be added in a future.
