<?php

/**
 *   ApiException
 * 
 *   Exception that works with arrays instead of plain strings 
 * 
 * 
 */
class ApiException extends Exception {

	protected $header;
	private $customMessage;

	/**
	 * Builds an api exception
	 * 
	 * @param string $message
	 * @param string $header
	 * @param string $code
	 * @param Exception $previous
	 */
	function __construct($message, $header, $code, Exception $previous = NULL) {
		parent::__construct($message, $code, $previous);

		$this->header = $header;
		$this->customMessage = array();
	}

	/**
	 * Returns header
	 * 
	 * @return string
	 */
	public function getHeader() {
		return $this->header;
	}
	
	/**
	 * Adds a custom field to the asArray representation of this exception
	 * 
	 * @param string $key
	 * @param type $value
	 */
	public function addCustomMessageToArray($key, $value) {
		$this->customMessage[$key] = $value;
	}

	/**
	 * 
	 * @return array
	 */
	public function asArray() {
		$arrayToReturn =  array(
			"status" => "error",
			"error" => $this->message,
			"errorcode" => $this->code,
			"header" => $this->header,
			"cause" => !is_null($this->getPrevious()) ? $this->getPrevious()->getMessage() : NULL,
			"trace" => $this->getTraceAsString(),
		);
		
		return array_merge($arrayToReturn, $this->customMessage);
	}
	
	/**
	 * Returns exception info intended for public error msgs in http responses
	 * 
	 * @return array
	 */
	public function asResponseArray() {

		// Obtener el texto final (ya localizado) de smarty.	
		global $smarty;
		$arrayToReturn =  array(
			"status" => "error",
			"error" => $smarty->getConfigVars($this->message), //; $this->message,
			"errorcode" => $this->code,
			"header" => $this->header
		);
		
		return array_merge($arrayToReturn, $this->customMessage);
	}

}

/**
 * InvalidArgumentException
 * 
 */
class InvalidParameterException extends ApiException {

	/**
	 * 
	 * @param string $message
	 * @param Exception $previous
	 */
	function __construct($message, Exception $previous = NULL) {
		parent::__construct($message, 'HTTP/1.1 400 BAD REQUEST', 400, $previous);
	}

}

/**
 * DuplicatedEntryInDatabaseException
 * 
 */
class DuplicatedEntryInDatabaseException extends ApiException {

	/**
	 * 
	 * @param string $message
	 * @param Exception $previous
	 */
	function __construct($message, Exception $previous = NULL) {
		parent::__construct($message, 'HTTP/1.1 400 BAD REQUEST', 400, $previous);
	}

}

/**
 * DuplicatedEntryInDatabaseException
 * 
 */
class InvalidDatabaseOperationException extends ApiException {

	/**
	 *  
	 * @param Exception $previous
	 */
	function __construct(Exception $previous = NULL) {
		parent::__construct("generalError", 'HTTP/1.1 400 BAD REQUEST', 400, $previous);
	}

}

/**
 * NotFoundException
 * 
 */
class NotFoundException extends ApiException {

	/**
	 * 
	 * @param string $message
	 * @param Exception $previous
	 */
	function __construct($message, Exception $previous = NULL) {
		parent::__construct($message, 'HTTP/1.1 404 NOT FOUND', 404, $previous);
	}

}

/**
 * ForbiddenAccessException
 * 
 */
class ForbiddenAccessException extends ApiException {

	/**
	 * 
	 * @param string $message
	 * @param Exception $previous
	 */
	function __construct($message = "userNotAllowed", Exception $previous = NULL) {
		parent::__construct($message, 'HTTP/1.1 403 FORBIDDEN', 403, $previous);
	}

}

/**
 * PreconditionFailed
 * 
 */
class PreconditionFailedException extends ApiException {

	/**
	 * 
	 * @param string $message
	 * @param Exception $previous
	 */
	function __construct($message = "userNotAllowed", Exception $previous = NULL) {
		parent::__construct($message, 'HTTP/1.1 412 PRECONDITION FAILED', 412, $previous);
	}

}

/**
 * Filesystem operation failed
 * 
 */
class InvalidFilesystemOperationException extends ApiException {

	/**
	 * 
	 * @param string $message
	 * @param Exception $previous
	 */
	function __construct($message = "generalError", Exception $previous = NULL) {
		parent::__construct($message, 'HTTP/1.1 500 INTERNAL SERVER ERROR', 500, $previous);
	}

}

/**
 * Default for unexpected errors
 * 
 */
class InternalServerErrorException extends ApiException {

	/**
	 * 
	 * @param Exception $previous
	 */
	function __construct(Exception $previous = NULL) {
		parent::__construct("generalError", 'HTTP/1.1 500 INTERNAL SERVER ERROR', 500, $previous);
	}

}

/**
 * Login failed exception
 * 
 */
class InvalidCredentialsException extends ApiException {

	/**
	 * 
	 * @param string $message
	 * @param Exception $previous
	 */
	function __construct(Exception $previous = NULL) {
		parent::__construct("usernameOrPassIsWrong", "HTTP/1.1 403 FORBIDDEN", 101, $previous);
	}

}

class NotAllowedToSubmitException extends ApiException {
	
	function __construct($message = "unableToSubmit", Exception $previous = NULL) {
		parent::__construct($message, "HTTP/1.1 401 FORBIDDEN", 501, $previous);
	}
}


class EmailNotVerifiedException extends ApiException {

	/**
	 * 
	 * @param string $message
	 * @param Exception $previous
	 */
	function __construct(Exception $previous = NULL) {
		parent::__construct("emailNotVerified", "HTTP/1.1 403 FORBIDDEN", 600, $previous);
	}

}


class EmailVerificationSendException extends ApiException {

	/**
	 * 
	 * @param string $message
	 * @param Exception $previous
	 */
	function __construct(Exception $previous = NULL) {
		parent::__construct("errorWhileSendingMail", "HTTP/1.1 500 INTERNAL SERVER ERROR", 601, $previous);
	}

}

/**
 * ProblemDeploymentFailedException
 * 
 */
class ProblemDeploymentFailedException extends ApiException {

	/**
	 * 
	 * @param string $message
	 * @param Exception $previous
	 */
	function __construct(Exception $previous = NULL) {
		parent::__construct("unableToDeployProblem", 'HTTP/1.1 412 PRECONDITION FAILED', 412, $previous);		
	}

}
