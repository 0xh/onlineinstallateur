# Multiple Fulfilment Centers

This module allows to manage locations and stock quantities from the backoffice.

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is MultipleFullfilmentCenters.
* Activate it in your thelia administration panel

## Usage

This module have two different configuration :

1. Global and default configuration
-----------------------------------

In module configuration you can add new locations, the address, gps coordinates and stock limit

2. Product configuration
------------------------

For each product you can specify the location and the stock quantity available on that location

3. Usage
--------

First you should populate the list with the locations and then add for each product the locations and stock available

## Hook

### backoffice :
- product.tab-content

### frontoffice :


## Loop

[fulfilment_center]
------------------------

### Output arguments

|Variable                   |Description |
|---                        |--- |
|$NAME			            | The name of the location/ center |
|$ADDRESS			        | The address of the location |
|$GPSLAT                    | GPS latitude coordinates |
|$GPSLONG                   | GPS longitude coordinates |
|$STOCKLIMIT                | The stock limit available for the location |

### Example

```
smarty
    {loop type="fulfilment_center" name="fulfilment_center"}
					                          
      	<input type="hidden" name="{$name}" value="{$ID}">
		<input type="text" name="{$name}" value="{$NAME}">
		<input type="text" name="{$name}" value="{$ADDRESS}">
		<input type="text" name="{$name}" value="{$GPSLAT}">
		<input type="text" name="{$name}" value="{$GPSLONG}">
		<input type="text" name="{$name}" value="{$STOCKLIMIT}">
    {/loop}
 ```
 
[product_stock_fulfilment_center]
---------------------------------

### Input arguments

|Argument |Description |
|---      |--- |
|**product_id** | The id of the product |

### Output arguments

|Variable                   |Description |
|---                        |--- |
|$CENTERID			    	| The id of the location, in relation with the id from 'fulfilment_center' table |
|$CENTERNAME			    | The name of the location/ center |
|$PRODUCTID			        | Product id, in relation with the id from 'product' table |
|$PRODUCTSTOCK              | Product quantity stock available on this location |
|$INCOMINGSTOCK             |  |
|$OUTGOINGSTOCK             |  |

 