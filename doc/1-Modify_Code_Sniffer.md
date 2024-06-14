# Modify Code Sniffer

## Description of Code Sniffer

Code Sniffer is a very powerful tool that helps to keep code clean and prevent simple mistakes. The Sniffer can find all
existing issues, and can also auto-fix the majority of them.

## Available command options

In docker/sdk tool type:

1) To sniff whole project

```shell
console code:sniff:style
```

2) To sniff specific module in project (looks into all application layers Zed, Yves, Client etc.)<br>
   `Recommended`

```shell
 console code:sniff:style -m ModuleName
```

3) To fix errors for specific module, that can be fixed by Code Sniffer

```shell
 console code:sniff:style -m ModuleName -f
```

4) Shortcut for `code:sniff:style`

```shell
 console c:s:s
```

## Disable rule

You can disable some rules from Code Sniffer. Rules are classes located in vendor. The fastest way to find specific rule
is to search by its error comment. For example:<br>
Error `No file code block` says that there should be some comment at the top of the class. This requirement is not
always required for the code, so it can be removed. This error is located in `FileDocBlockSniff` class. It can be
removed by modify `phpcs.xml` file.<br>
At the bottom of the file insert:

```xml
<rule ref="Spryker.Commenting.FileDocBlock">
    <severity>0</severity>
</rule>
```

Rule ref is a path to FileDocBlockSniff class. Let's compare namespace `Spryker\Sniffs\Commenting\FileDocBlockSniff`
with rule name. You can see that the `Sniffs` directory has been omitted and suffix `Sniff` has been removed from the
end of the class name.<br>
`<severity>0</severity>` is disabling the rule.
