<?php
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

function has_ip_address($domain)
{
    $ip_address = gethostbyname($domain);
    return $ip_address !== $domain;
}

function has_trailing_slash($url)
{
    $parsed_url = parse_url($url);
    if (isset($parsed_url['path']) && substr($parsed_url['path'], -1) === '/') {
        return true;
    } else {
        return false;
    }
}

function detect_url_scheme($url)
{
    $parsed_url = parse_url($url);

    if (isset($parsed_url['scheme'])) {
        $scheme = strtolower($parsed_url['scheme']);
        if ($scheme === 'https') {
            return 'https';
        } elseif ($scheme === 'http') {
            return 'http';
        }
    }
}
if (isset($_GET['key'])) {
    $name = mysqli_real_escape_string($conn, $_GET['name']);
    $dsc = mysqli_real_escape_string($conn, $_GET['description']);
    $host = mysqli_real_escape_string($conn, $_GET['host']);
    $auth_key = mysqli_real_escape_string($conn, $_GET['auth_key']);
    if (!$name == "" && !$host == "" && !$auth_key == "") {
        if (!has_ip_address($host)) {
            if (!filter_var($host, FILTER_VALIDATE_URL) === false) {
                if (!has_trailing_slash($host)) {
                    $scheme = detect_url_scheme($host);
                    if ($scheme === 'https') {
                        $client = new Client();

                        try {
                            $response = $client->get($host . '/connection', [
                                'query' => ['auth_key' => $auth_key],
                            ]);

                            $statusCode = $response->getStatusCode();
                            $data = json_decode($response->getBody(), true);

                            if ($statusCode === 200) {
                                if (json_last_error() === JSON_ERROR_NONE) {
                                    if (isset($data['code']) && $data['code'] === 200) {
                                        $user_query = "SELECT * FROM mythicalpics_nodes WHERE name = ? AND host = ?";
                                        $stmt = mysqli_prepare($conn, $user_query);
                                        mysqli_stmt_bind_param($stmt, "ss", $name, $host);
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);
                                        if (!mysqli_num_rows($result) > 0) {
                                            $conn->query("INSERT INTO `mythicalpics_nodes` (`name`, `description`, `host`, `auth_key`) VALUES ('" . $name . "', '" . $dsc . "', '" . $host . "', '" . $auth_key . "')");
                                            $conn->close();
                                            $stmt->close();
                                            header('location: /admin/nodes?s=We connected to the node: <code>' . $data['message'] . '</code>');
                                            die();
                                        } else {
                                            $conn->close();
                                            $stmt->close();
                                            header('location: /admin/nodes?e=Failed to connect to the node: <code>This node already exists in the database.</code>');
                                            die();
                                        }
                                    } else {
                                        header('location: /admin/nodes?e=Failed to connect to the node: <code>' . $data['message'] . '</code>');
                                        die();
                                    }
                                } else {
                                    header('location: /admin/nodes?e=Failed to connect to the node: <code>Invalid JSON response</code>');
                                    die();
                                }
                            } else {
                                header('location: /admin/nodes?e=Failed to connect to the node: <code>Unexpected status code:'.  $statusCode .'</code>');
                                die();
                            }
                        } catch (RequestException $e) {
                            if ($e->hasResponse()) {
                                $response = $e->getResponse();
                                $statusCode = $response->getStatusCode();

                                $data = json_decode($response->getBody(), true);

                                if (json_last_error() === JSON_ERROR_NONE) {
                                    header('location: /admin/nodes?e=Failed to connect to the node: <code>' . $data['message'] . '</code>');
                                    die();
                                } else {
                                    header('location: /admin/nodes?e=Failed to connect to the node: <code>' . $response->getReasonPhrase() . '</code>');
                                    die();
                                }
                            } else {
                                header('location: /admin/nodes?e=Failed to connect to the node: <code>' . $e->getMessage() . '</code>');
                                die();
                            }
                        }
                    } else {
                        header('location: /admin/nodes?e=Failed to connect to the node: <code>Please use a https connection</code>');
                        die();
                    }

                } else {
                    header('location: /admin/nodes?e=Failed to connect to the node: <code>This is not a valid url please remove the / after the url</code>');
                    die();
                }

            } else {
                header('location: /admin/nodes?e=Failed to connect to the node: <code>This is not a valid url</code>');
                die();
            }
        } else {
            header('location: /admin/nodes?e=Failed to connect to the node: <code>This is not a valid domain</code>');
            die();
        }

    } else {
        header('location: /admin/nodes?e=It looks like the required fields are empty.');
        die();
    }
} else {
    header('location: /admin/nodes');
    die();
}
?>