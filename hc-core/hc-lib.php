<?php
class hcLib{
	
	public $nav;
	
	public function __construct()
	{
		$this->registerIASection(array(
									'Dashboard',
									'Users',
									'Transactions'=>
											array(
											'Add/Edit',
											'Search',
											'Stats'
											),
									'Settings',
									'Plugins',
									'Profile'
									));
		$this->buildNav();
	}
	
	public function registerIASection($name)
	{
		if(is_string($name)) $this->nav[] = $name;
		if(is_array($name))
		{
			foreach($name as $item)
			{
				$this->nav[] = $item;
			}
		}
		
	}
	
	public function buildNav()
	{
		foreach($this->nav as $item)
		{
			if(is_string($item)) echo '<a href="/'.strtolower($item).'">'.$item.'</a><br/>';
			if(is_array($item))
			{
				foreach($item as $subItemK => $subItemV)
				{
					if(is_string($subItemV)) echo '<a href="/'.strtolower($subItemK).'/'.strtolower($subItemV).'">'.$subItemV.'</a><br/>';
				}
			}
		}
	}
}
$HC = new hcLib();