HeaderHelper.php
=============

HeaderHelper.php file containing several easy-to-use functions to extend CakePHP functionality.

In CakePHP, the file is located under the '/View/helper/' directory under your main CakePHP directory (typically app).  Simply, find the function(s) you'd like to use and place it in your HeaderHelper.php file.

This file is mainly used for the formating of views to create a more pleasant expiernce for the end user, but also contains some input functions for quicker inputs for standard information.

Example
=============

Assuming you want to add a U.S state or territory field on your input form and your field is called 'state'.  The add.ctp View would contain:

```
<?php
   echo $this->Form->input('state', array('type'=>'select', 'options'=>$this->Header->getState()));
   echo $this->Form->end('Save');
?>
```

Edit.ctp would then contain:
```
<?php
  echo $this->Form->input('state', array('type'=>'select', 'options'=>$this->Header->getState($this->request->data['YourArray']['state'])));
  echo $this->Form->end('Save');
?>
```

Where `$this->request->data['YourArray']['state'])));` would contain the correct name of the model you are using in place of 'YourArray'.  Passing the array value as an argument in the function is not necessary, but will display the value the use has selected.
