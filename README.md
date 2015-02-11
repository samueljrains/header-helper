HeaderHelper.php
=============

HeaderHelper.php file containing several easy-to-use functions to extend CakePHP functionality.

In CakePHP, the file is located under the '/View/helper/' directory under your main CakePHP directory (typically app).  Simply, find the function(s) you'd like to use and place it in your HeaderHelper.php file.

This file is mainly used for the formatting of views to create a more pleasant experience for the end user, but also contains some input functions for quicker inputs for standard information.

Example
=============

Assuming you want to add a U.S state or territory field on your input form and your field is called 'state'.  The add.ctp and edit.ctp View would contain:

```
<?php
   echo $this->Form->input('state', array('type'=>'select', 'options'=>$this->Header->getState()));
   echo $this->Form->end('Save');
?>
```

Edit.ctp would contain:
```
<?php
  echo $this->Form->input('state', array('type'=>'select', 'options'=>$this->Header->getState($this->request->data['YourArray']['state'])));
  echo $this->Form->end('Save');
?>
```

Where `$this->request->data['YourArray']['state'])));`  contians the correct data array value you are passing.  Optional call.
