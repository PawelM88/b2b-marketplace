# Order Details Email Notifications Process

## Acceptance Criteria:

- Review the email notifications functionality.
  The user should receive an email notification:
- placing a new order
- payment confirmation
- shipping order
- order cancellation
- Emails content should be customized by Grundfos
- The email templates can be edited inside the Back office in a CMS Block and are available as HTML and text versions.

### Sending mail process in details
Sending e-mails with notifications to the buyer is related to `OMS`, and more specifically to `events` in a specific `transition`. For a process to move from one state to another, an event is needed. Below is one transition from `source new` to `target paid`. The transition is triggered by a `pay event`:
```xml
<transition happy="true">
  <source>new</source>
  <target>paid</target>
  <event>pay</event>
</transition>
```
Events may have `commands`, which may be plugins (in this case, e.g. plugins responsible for sending e-mails). Commands are executed together with events:
```xml
<events>
  <event name="pay" manual="true" command="Oms/SendPaymentConfirmationMessage"/>
</events>
```
The above command name should be entered into the extendCommandPlugins() method in the OmsDependencyProvider class:
```php
$commandCollection->add(new SendPaymentConfirmationMessagePlugin(), 'Oms/SendPaymentConfirmationMessage'); 
```
Thanks to this, the plugin `SendPaymentConfirmationMessagePlugin` will be launched in the `Spryker\Zed\Oms\Business\OrderStateMachine\OrderStateMachine` class in the `if condition` on line 572. <br>
Plugins from the Oms command most often refer to Facade, which refers to the `sendMail()` method in the `MailHandler` class. <br>
There, a new TransferObject `MailTransfer()` is created, to which an email type is attached, which is actually another plugin. This plugin must be attached to the `getMailTypeBuilderPlugins()` method in the `MailDependencyProvider` class. <br>
The last steps left are to create two twig files and add a new CMS block. <br>
`HTML`
```
{{ renderCmsBlockAsTwig(
	'payment-confirmation--html',
	mail.storeName,
	mail.locale.localeName,
	{mail: mail}
) }}
```
`Text`
```
{{ renderCmsBlockAsTwig(
	'payment-confirmation--text',
	mail.storeName,
	mail.locale.localeName,
	{mail: mail}
) }}
```
To create a new CMS block, two csv files must be modified: `cms-block-store.csv`:
```csv
cms-block-email--payment-confirmation--html,DE
cms-block-email--payment-confirmation--text,DE
```
and `cms_block.csv`. <br>
The content of `cms_block.csv` is too big to put in here. Try to find it by `cms-block-email--payment-confirmation--text` and `cms-block-email--payment-confirmation--html`. <br>
Additionally, in order for the email content to be displayed correctly, you need to modify the `glossary.csv` file, e.g.:
```csv
mail.payment.confirmation.subject,Payment confirmation for purchases at Spryker Shop,en_US
```
```csv
mail.trans.payment_confirmation.title,Thank you for paying for you order at Spryker Shop!,en_US
mail.trans.payment_confirmation.subtitle,"We are writing to inform you that we have received payment for your order. It is now being prepared to be shipped to the merchant.",en_US
```
### Important information regarding Merchant Portal State Machine
After triggering the `ship` event in the Merchant Portal, Spryker calls the `runCommand()` method in the vendor class `Spryker\Zed\StateMachine\Business\StateMachine\Trigger()`.<br>
The `foreach` construct is implemented at the very beginning. Inside it, the `$comamnd->run()` command is iterated through each product from the order.<br>
This causes the `SendOrderShippedByMerchantMessagePlugin` plugin (responsible for sending an e-mail with information about the shipment of the order) and `SendCancelOrderMessagePlugin` (responsible for sending an e-mail with information about the cancellation of the order) to be initiated as many times as there are products in the order.<br>
To prevent this, it was necessary to create `MailSentStatusManager` class with static property `$mailSent` and implement `if condition` in these two plugins.
```php
public function run(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data): array
    {
        $mailSentStatusManager = MailSentStatusManager::getInstance();

        if (!$mailSentStatusManager::$mailSent) {
            $mailTypeBuilderPlugin = $this->getMailTypeBuilderPluginType();

            $this->getFactory()->getPyzOmsFacade()->sendMessage($orderEntity, $mailTypeBuilderPlugin);

            $mailSentStatusManager::$mailSent = true;
        }

        return [];
    }
```
