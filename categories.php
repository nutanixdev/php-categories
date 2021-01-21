<?php

require_once('./vendor/autoload.php');

# load the script configuration
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$pc_ip = $_ENV['PC_IP'];
$pc_port = $_ENV['PC_PORT'];
$pc_username = $_ENV['PC_USERNAME'];
$pc_password = $_ENV['PC_PASSWORD'];

echo("Prism Central IP: " . $pc_ip . "\n");
echo("Prism Central Port: " . $pc_port . "\n");

# reusable Guzzle HTTP client instance
$client = new GuzzleHttp\Client();

# grab and decode the category details from the included JSON file
$raw_json = file_get_contents('categories.json');
$json = json_decode($raw_json);

# start building the BATCH request
echo("Building the BATCH request payload that will create the category keys ...\n");
$batch_payload = [
	"action_on_failure" => "CONTINUE",
	"execution_order" => "SEQUENTIAL",
	"api_request_list" => [
	],
	"api_version" => "3.1"
];

foreach($json->categories[0]->keys as $key) {
	# do something with the keys here
	# probably use the API to create the keys, as shown below

	$category_key_payload = [
		"operation" => "PUT",
		"path_and_params" => "/api/nutanix/v3/categories/" . $key,
		"body" => [
			"name" => $key,
			"description" => $key,
			"capabilities" => [
				"cardinality" => 64
			],
			"api_version" => "3.1"
		]
	];

	# add the new API request to the batch payload's BODY
	$batch_payload["api_request_list"][] = $category_key_payload;
	
}

# submit the BATCH request that will create the category keys
echo("Creating the category keys via API BATCH request ...\n");
$res = $client->request('POST', 'https://' . $pc_ip . ':' . $pc_port . '/api/nutanix/v3/batch', [
	'auth' => [
		$pc_username,
		$pc_password
	],
	'verify' => false,
	'headers' => [
		'Content-Type' => 'application/json'
	],
	'body' => json_encode($batch_payload)
]);

# check the results of the request
echo("BATCH request HTTP status code: " . $res->getStatusCode() . "\n");
$json_response = json_decode($res->getBody()->getContents());
echo("There are " . count($json_response->api_response_list) . " responses from this request.\n");
foreach($json_response as $response_item) {
	foreach($response_item as $response_details) {
		echo("Response code: " . $response_details->status . " | path_and_params: " . $response_details->path_and_params . "\n");
	}
}

# start building the next BATCH request
echo("Building the BATCH request payload that will create the category values ...\n");
$batch_payload = [
	"action_on_failure" => "CONTINUE",
	"execution_order" => "SEQUENTIAL",
	"api_request_list" => [
	],
	"api_version" => "3.1"
];

foreach($json->categories[0]->values as $value) {
	# do something with the values here
	# probably use the API to create values, as shown below

	$category_value_payload = [
		"operation" => "PUT",
		"path_and_params" => "/api/nutanix/v3/categories/" . $value->key . "/" . $value->value,
		"body" => [
			"value" => $value->value,
			"description" => $value->value,
			"assignment_rule" => [
				"name" => "assignment rule name created by API",
				"description" => "assignment rule value created by API",
				"selection_criteria_list" => [
				]
			],
			"api_version" => "3.1"
		]
	];

	# add the new API request to the batch payload's BODY
	$batch_payload["api_request_list"][] = $category_value_payload;

}

# submit the BATCH request that will create the category keys
echo("Creating the category values via API BATCH request ...\n");
$res = $client->request('POST', 'https://' . $pc_ip . ':' . $pc_port . '/api/nutanix/v3/batch', [
	'auth' => [
		$pc_username,
		$pc_password
	],
	'verify' => false,
	'headers' => [
		'Content-Type' => 'application/json'
	],
	'body' => json_encode($batch_payload)
]);

# check the results of the request
echo("BATCH request HTTP status code: " . $res->getStatusCode() . "\n");
$json_response = json_decode($res->getBody()->getContents());
echo("There are " . count($json_response->api_response_list) . " responses from this request.\n");
foreach($json_response as $response_item) {
	foreach($response_item as $response_details) {
		echo("Response code: " . $response_details->status . " | path_and_params: " . $response_details->path_and_params . "\n");
	}
}