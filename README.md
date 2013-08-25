php-quick-template
==================

Lightweight PHP Template Engine

###Usage
1. **Define data** 
2. **Call the create method** 
3. **Deploy a template**
    

Using an indexed array
```php 
  <?php 
  QuickTemplate::create(array('Toyota', 'Honda', 'Ford'), function() { ?>
    <li>%item%</li><br>
  <?php });
```

Using an associative array
```php
<?php
$state_list = array(
  'AL'=>"Alabama",  
  'AK'=>"Alaska",  
  'AZ'=>"Arizona",  
  'AR'=>"Arkansas",  
  'CA'=>"California",  
  'CO'=>"Colorado",  
  'CT'=>"Connecticut" ... 
);

QuickTemplate::create($state_list, function() { ?>
  <option value="%key%" class="states template %inc%">%value%</option>
<?php }, &$states_content); ?>
```

Using a two dimensional array
```php
<?php
$data = array(
  array(
    'title'     => 'My test title 1',
    'paragraph' => 'Lorem ipusm color dolor.'
  ),
  array(
    'title'     => 'My test title 2',
    'paragraph' => 'just another paragraph',
    'date'      => 'Jan 3rd, 2014'
  )
);

QuickTemplate::create($data, function() { ?>
  
  <!-- my custom template %inc% -->
  <div class="template %inc%">
    <strong>%title%</strong>
    <p>%paragraph%</p>
    <span>%date%</span>
  </div>
  <!-- end -->
  
<?php }); ?>
```

###Requirements:
 PHP 5.4 or greater
 
### Examples
[dev.jasandpereza.com/quick-template](http://dev.jasandpereza.com/quick-template "Quick Template Examples")

### Notes from author
This is pretty much as beta version. Work may or may not continue. If you have any comments or questions, please email me at [jasandpereza@hotmail.com](mailto:jasandpereza@hotmail.com)

 
