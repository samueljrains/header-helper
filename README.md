HeaderHelper.php
=============

HeaderHelper.php file containing several easy-to-use functions to extend CakePHP functionality.

In CakePHP, the file is located under the '/View/helper/' directory under your main CakePHP directory (typically app).  Simply, find the function(s) you'd like to use and place it in your HeaderHelper.php file.

This file is mainly used for the formating of views to create a more pleasant expiernce for the end user, but also contains some input functions for quicker inputs for standard information.

Example
=============

Assuming you want to add a state field on your input form and your field is called 'state'.  The add.ctp line would contain:

`echo $this->Form->input('state', array('type'=>'select', 'options'=>$this->Header->getState()));`

Edit.ctp would contain:
`echo $this->Form->input('state', array('type'=>'select', 'options'=>$this->Header->getState($this->request->data['YourArray']['state'])));`

Where `$this->request->data['YourArray']['state'])));` would be the correct name of the model you are using.
