# Build Contact Form

## Acceptance Criteria:

- contact form should be on every merchant's profile site
- contact form should contain `name`, `phone number`, `e-mail`, `subject` and `message box`.

## Details for developers

- To be able to display the form on the `merchant/profile` page, you had to overwrite the Controller from the vendor: `SprykerShop\Yves\MerchantPage\Controller\MerchantController`. The return type in this Controller is declared (as `View`) and cannot be changed. Hence, it is not possible to use the `$this->redirectResponseInternal()` method.
- Merchant validation involves checking whether the `merchantReference` and `publicEmail` downloaded from the `merchant/profile` website exist in the database.
- To send an email, `mailFacade` was used with the `handleMail()` method.
- The template for the email being sent is in the file `cms_block.csv` as `contact-form--html` and `contact-form--text`.

## Tests

The tests check whether merchant can be found in database.

To run tests go to docker/sdk cli with test mode

```shell
docker/sdk cli -t
```

First, create necessary testing class:
```shell
codecept build -c tests/PyzTest/Zed/MerchantPage/
```

Then type: `codecept run -c tests/PyzTest/Zed/MerchantPage/`
```shell
codecept run -c tests/PyzTest/Zed/MerchantPage/
```
