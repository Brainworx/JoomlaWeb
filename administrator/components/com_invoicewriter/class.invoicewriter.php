<?php
/**
* Brainworx Invoicewriter Component
* @package Invoicewriter
* @copyright (C) 2010 Brainworx / All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.brainworx.be
*
* @Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @author Stijn Heylen / Brainworx
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class josIVIncome extends mosDBTable {

	var $id=null;
	var $iv_id=null;
	var $company_id=null;
	var $date=null;
	var $due_date=null;
	var $period_start=null;
	var $period_end=null;
	var $description=null;
	var $amount=null;
	var $tax_perc=null;
	var $tax=null;
	var $total_amount=null;
	var $currency=null;
	var $book_date=null;
	var $ogm=null;

	function josIVIncome( &$db ) {
		$this->mosDBTable( 'f9ko_iv_income', 'id', $db );
	}
}

class josIVIncomeFPline extends mosDBTable {

	var $id=null;
	var $invoice_id=null;
	var $description=null;
	var $quantity=null;
	var $total_amount=null;
	var $amount_unit=null;
	var $unit=null;
	var $currency=null;

	function josIVIncomeFPline( &$db ) {
		$this->mosDBTable( 'f9ko_iv_income_fpline', 'id', $db );
	}
}

class josIVSupplier extends mosDBTable {

	var $id=null;
	var $supplier_name=null;
	var $company_id=null;  
	var $description=null;  
	var $telephone=null;
	var $contact_name=null;
	var $email=null;
	var $website=null;
	var $vat_reg_no=null;
	var $address=null;

	function josIVSupplier( &$db ) {
		$this->mosDBTable( 'f9ko_iv_supplier', 'id', $db );
	}
}

class josIVExpense extends mosDBTable {

	var $id=null;
	var $supplier_id=null;
	var $expensetype_id=null;
	var $date=null;
	var $description=null;
	var $amount=null;
	var $tax=null;
	var $total_amount=null;
	var $currency=null;
	var $book_date=null;
	var $ogm=null;
	var $invoice_received=null;

	function josIVExpense( &$db ) {
		$this->mosDBTable( 'f9ko_iv_expense', 'id', $db );
	}
}
class josIVExpenseType extends mosDBTable {

	var $id=null;
	var $start_date=null;
	var $end_date=null;
	var $description=null;
	var $perc_deductable=null;
	var $perc_deductable_tax=null;

	function josIVExpenseType( &$db ) {
		$this->mosDBTable( 'f9ko_iv_expensetype', 'id', $db );
	}
}

class josIVTax extends mosDBTable {

	var $id=null;
	var $taxtype_id=null;
	var $date=null;
	var $description=null;
	var $amount=null;
	var $currency=null;
	var $book_date=null;

	function josIVTax( &$db ) {
		$this->mosDBTable( 'f9ko_iv_tax', 'id', $db );
	}
}
class josIVTaxType extends mosDBTable {

	var $id=null;
	var $description=null;

	function josIVTaxType( &$db ) {
		$this->mosDBTable( 'f9ko_iv_taxtype', 'id', $db );
	}
}

class josIVInvest extends mosDBTable {

	var $id=null;
	var $description=null;
	var $amount=null;
	var $currency=null;
	var $book_date=null;

	function josIVInvest( &$db ) {
		$this->mosDBTable( 'f9ko_iv_invest', 'id', $db );
	}
}

class josIVStaff extends mosDBTable {

	var $id=null;
	var $user_id=0;
	var $jobtitle=null;
	var $passport_id=null;
	var $birth_date=null;
	var $start_date=null;
	var $end_date=null;
	var $address=null;
	var $telephone=null;

	function josIVStaff( &$db ) {
		$this->mosDBTable( 'f9ko_iv_staff', 'id', $db );
	}
}

class josIVUser extends mosDBTable {
	
	var $id=null;
	var $name=0;
	var $username=null;
	var $email=null;
	var $password=null;
	var $usertype=null;
	var $block=null;
	var $sendEmail=null;
	var $gid=null;
	var $registerDate=null;
	var $lastvisitDate=null;
	var $activation=null;
	var $params=null;

	function josIVUser( &$db ) {
		$this->mosDBTable( 'f9ko_users', 'id', $db );
	}
}

class josIVSalary extends mosDBTable {

	var $id=null;
	var $staff_id=null;
	var $date=null;
	var $description=null;
	var $amount=null;
	var $currency=null;
	var $book_date=null;

	function josIVSalary( &$db ) {
		$this->mosDBTable( 'f9ko_iv_salary', 'id', $db );
	}
}

class josOCCompany extends mosDBTable {

	var $id=null;
	var $user_id=null;
	var $company_name=null;
	var $address=null;
	var $general_contractor_id=null;
	var $description=null;
	var $telephone=null;
	var $contact_name=null;
	var $email=null;
	var $website=null;
	var $vat_reg_no=null;
	var $company_no=null;
	var $published=null;

	function josOCCompany( &$db ) {
		$this->mosDBTable( 'f9ko_oc_company', 'id', $db );
	}
}
