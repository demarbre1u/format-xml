# Format XML

## Introduction 

This command line tool is meant to strip ' <![CDATA[ ... ]]> ' from an XML file.
It prints the result in the standard output.

Needs PHP@7.4 or higher to run.

Here is an example :

```
XML input : 
<?xml version="1.0" encoding="UTF-8"?>
<Object>
    <Id>
        <![CDATA[2]]>
    </id>
    <SomeData1>
        <![CDATA[49]]>
    </SomeData1>
    <SomeData2>
        <![CDATA[0]]>
    </SomeData2>
    <SomeRandomText>
        <![CDATA[Here is some random text in a CDATA tag]]>
    </SomeRandomText>
</Object>

XML output : 
<?xml version="1.0" encoding="UTF-8"?>
<Object>
    <Id>2</id>
    <SomeData1>49</SomeData1>
    <SomeData2>0</SomeData2>
    <SomeRandomText>Here is some random text in a CDATA tag</SomeRandomText>
</Object> 
```

## How to use 

```
Usage: php format-xml.php [options] [filename]
	--help, -h : displays this text
	filename : the file containing the XML to format
```