<?php defined('IN_IA') or exit('Access Denied');?><ul class="nav nav-tabs">
    <?php if(cv('supplier.supplier')) { ?><li <?php  if($_GPC['method']=='supplier') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createPluginWebUrl('supplier/supplier')?>">供应商管理</a></li><?php  } ?>
    <?php if(cv('supplier.supplier_apply')) { ?><li <?php  if($_GPC['method']=='supplier_apply') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createPluginWebUrl('supplier/supplier_apply')?>">供应商提现申请</a></li><?php  } ?>
    <?php if(cv('supplier.supplier_finish')) { ?><li <?php  if($_GPC['method']=='supplier_finish') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createPluginWebUrl('supplier/supplier_finish')?>">供应商提现完成</a></li><?php  } ?>
    <?php if(cv('supplier.supplier_for')) { ?><li <?php  if($_GPC['method']=='supplier_for') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createPluginWebUrl('supplier/supplier_for')?>">会员申请供应商</a></li><?php  } ?>
</ul>
