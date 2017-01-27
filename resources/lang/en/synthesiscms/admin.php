<?php

return [
	'err_cannot_delete_default_molecule' => 'The default molecule (ID 1) cannot be deleted!',
	'err_no_molecules_selected' => 'In order to perform this operation, first you have to select some molecules!',
	'msg_molecules_copied' => ':count :beginning successfully been copied',
	'msg_molecules_deleted' => ':count :beginning successfully been deleted',
	'msg_molecules_and_child_atoms_deleted' => ':moleculesCount and :atomsCount have successfully been deleted',
	'err_no_atoms_selected' => 'In order to perform this operation, first you have to select some atoms!',
	'msg_atoms_copied' => ':count :beginning successfully been copied',
	'msg_atoms_moved' => ':count :beginning successfully been moved to molecule with ID :molecule',
	'msg_atoms_deleted' => ':count :beginning successfully been deleted',
	'menu_select_actions' => 'Actions',
	'menu_select_actions_swap_selection' => 'Swap Selection',
	'menu_select_actions_select_all' => 'Select All',
	'menu_select_actions_unselect_all' => 'Unselect All',
	'no_atoms' => 'No Atoms',
	'msg_route_cannot_be_deleted' => 'This is the default Molecule! It cannot be deleted!',
	'edit_atom' => 'Edit Atom',
	'choose_atom' => 'Choose Atom',
	'manage_atoms' => 'Manage Atoms',
	'create_atom' => 'Create Atom',
	'create_atom_title_tooltip' => 'Name the Atom (this will be the title displayed on the site)',
	'create_atom_title_label' => 'Atom Title',
	'create_atom_description_tooltip' => 'Describe the Atom (this will be the description displayed on the site)',
	'create_atom_description_label' => 'Atom Description',
	'msg_atom_saved' => 'Atom :name has been successfully saved',
	'msg_atom_created' => 'Atom :name has been successfully created',
	'msg_atom_deleted' => 'Atom :name has been successfully deleted',
	'save_molecule' => 'Save Molecule',
	'cancel_molecule' => 'Cancel',
	'save_atom' => 'Save Atom',
	'cancel_atom' => 'Cancel',
	'edit_molecule' => 'Edit Molecule',
	'choose_molecule' => 'Choose Molecule',
	'manage_molecules' => 'Manage Molecules',
	'create_molecule' => 'Create Molecule',
	'create_molecule_title_tooltip' => 'Name the Molecule (this will be the title displayed on the site)',
	'create_molecule_title_label' => 'Molecule Title',
	'create_molecule_description_tooltip' => 'Describe the Molecule (this will be the description displayed on the site)',
	'create_molecule_description_label' => 'Molecule Description',
	'msg_molecule_saved' => 'Molecule :name has been successfully saved',
	'msg_molecule_created' => 'Molecule :name has been successfully created',
	'msg_molecule_deleted' => 'Molecule :name has been successfully deleted',
	'err_header_cannot_be_empty' => 'Header cannot be empty!',
	'err_slug_cannot_be_empty' => 'Slug cannot be empty!',
	'err_title_cannot_be_empty' => 'Title cannot be empty!',
	'msg_route_saved' => 'Route :route has been successfully saved',
	'save_route' => 'Save Route',
	'cancel_route' => 'Cancel',
	'view_route' => 'View Route',
	'msg_now_edit_route' => 'Now please edit the route & it\'s module-specific settings',
	'msg_route_created' => 'Route :route has been successfully created',
	'msg_route_deleted' => 'Route :route has been successfully deleted',
	'create_route_slug_tooltip' => 'A route can be a wildcard (e.g. \'mypage\this\is\a\wildcard\')',
	'create_route_slug_label' => 'Page Route',
	'create_route' => 'Create Route',
	'stats' => 'Visitors Statistics',
	'manage_users' => 'Manage Users & Privileges',
	'manage_extensions' => 'Manage Extensions',
	'manage_routes' => 'Manage Routes',
	'settings' => 'Settings',
	'section_users' => 'Users & Administration',
	'section_routes' => 'Routes & Extensions',
	'section_content' => 'Content Management',
	'section_settings' => 'Settings',
	'backend' => 'Site Administration',
	'change_user_privileges' => 'Change User Privileges',
	'no_other_users' => 'No Other User Accounts Exist',
	'delete_user' => 'Delete User Account',
	'change_name_privileges' => 'Change :name\'s Privileges',
	'err_cant_edit_self_privileges' => 'You cannot change Your own profile\'s privileges',
	'msg_user_privileges_successfully_changed' => ':name\'s privileges has been successfully changed!',
	'modal_delete_user_header' => 'Are You sure?',
	'modal_delete_user_content' => 'Are You sure You want to delete this user account?',
	'modal_delete_user_content_2' => 'Remember, this cannot be undone!',
	'modal_delete_user_btn_yes' => 'Yes, I understand, kick them out!',
	'modal_delete_user_btn_no' => 'No, leave them alone!',
	'modal_mass_delete_atom_header' => 'Are You sure?',
	'modal_mass_delete_atom_content' => 'Are You sure You want to delete the selected atoms?',
	'modal_mass_delete_atom_content_2' => 'Remember, this cannot be undone!',
	'modal_mass_delete_atom_btn_yes' => 'Yes, I understand, dissolve them in acid!',
	'modal_mass_delete_atom_btn_no' => 'No, leave them alone!',
	'modal_mass_delete_molecule_header' => 'Are You sure?',
	'modal_mass_delete_molecule_content' => 'Are You sure You want to delete the selected molecules? If you don\'t choose the option to delete child atoms, they\'ll be moved to the default molecule (ID 1).',
	'modal_mass_delete_molecule_content_2' => 'Remember, this cannot be undone!',
	'modal_mass_delete_molecule_checkbox_delete_subatoms' => 'Also delete child atoms',
	'modal_mass_delete_molecule_btn_yes' => 'Yes, I understand, dissolve them in acid!',
	'modal_mass_delete_molecule_btn_no' => 'No, leave them alone!',
	'modal_mass_copy_molecule_header' => 'Are You sure?',
	'modal_mass_copy_molecule_content' => 'Please choose if you want to copy child atoms owned by the molecule(s) you want to copy.',
	'modal_mass_copy_molecule_content_2' => 'This action will not modify nor will it delete any existing molecules/atoms.',
	'modal_mass_copy_molecule_checkbox_copy_subatoms' => 'Also copy child atoms',
	'modal_mass_copy_molecule_btn_yes' => 'Yes, copy them',
	'modal_mass_copy_molecule_btn_no' => 'No, I don\'t want to copy anything!',
	'modal_mass_move_atom_header' => 'Are You sure?',
	'modal_mass_move_atom_content' => 'Please choose a molecule which You want to move the selected atoms to.',
	'modal_mass_move_atom_content_2' => 'Selected atoms do not have to come from the same molecule.',
	'modal_mass_move_atom_btn_yes' => 'Yes, move them',
	'modal_mass_move_atom_btn_no' => 'No, I don\'t want to move anything!',
	'modal_delete_route_header' => 'Are You sure?',
	'modal_delete_route_content' => 'Are You sure You want to delete the route :route ?',
	'modal_delete_route_content_2' => 'Remember, this cannot be undone!',
	'modal_delete_route_btn_yes' => 'Yes, delete this route!',
	'modal_delete_route_btn_no' => 'No, leave this route!',
	'modal_delete_molecule_header' => 'Are You sure?',
	'modal_delete_molecule_content' => 'Are You sure You want to delete the molecule :molecule ?',
	'modal_delete_molecule_content_2' => 'Remember, this cannot be undone!',
	'modal_delete_molecule_btn_yes' => 'Yes, delete this molecule!',
	'modal_delete_molecule_btn_no' => 'No, leave this molecule!',
	'modal_delete_atom_header' => 'Are You sure?',
	'modal_delete_atom_content' => 'Are You sure You want to delete the atom :atom ?',
	'modal_delete_atom_content_2' => 'Remember, this cannot be undone!',
	'modal_delete_atom_btn_yes' => 'Yes, delete this atom!',
	'modal_delete_atom_btn_no' => 'No, leave this atom!',
	'edit_route' => 'Edit Route :route',
	'delete_route' => 'Delete Route',
	'no_routes' => 'No Routes',
	'no_molecules' => 'No Molecules',
];

?>
