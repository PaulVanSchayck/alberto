<?php

namespace app\components;

use yii\base\Component;
use yii\db\ActiveQuery;
use yii\web\Response;
use yii\web\ResponseFormatterInterface;

/**
 * CsvResponseFormatter formats the given data into an XML response content.
 *
 * It is used by [[Response]] to format response data.
 */
class CsvResponseFormatter extends Component implements ResponseFormatterInterface
{
    public $separator = ",";

    /**
     * Formats the specified response.
     * @param Response $response the response to be formatted.
     */
    public function format($response)
    {
        $output = "";

        $response->setDownloadHeaders('alberto-export.csv', 'text/csv; charset=utf-8');

        // The status code, even upon error should be OK. This may be considered a hack
        $response->setStatusCode(200);

        if ( ! $response->data instanceof ActiveQuery ) {
            $output = "Error while exporting, please contact administrators \r\n";
        } else {

            $first = true;
            // Go batchwise through the data, to reduce the load on memory
            foreach( $response->data->batch(1000) as $rows ) {
                if ( $first ) {
                    $output = $this->csv_implode(array_keys($rows[0])) . "\r\n";
                    $first = false;
                }

                foreach ($rows as $row) {
                    // Remove trailing separator, add line ending
                    $output .= substr($this->csv_implode($row), 0, -1) . "\r\n";
                }
            }

        }

        // TODO: Make this a stream, to improve time required
        $response->content = $output;
    }

    private function value($val) {

        $val = trim($val);

        // Escape double quotes by double quotes
        $val = str_replace('"', '""', $val);

        // Quote fields with the separator or other funky chars in them
        if ( strpos($val, $this->separator) !== false ||
             strpos($val, "\n") !== false ||
             strpos($val, "\r") !== false ||
             strpos($val, "\t") !== false ||
             strpos($val, ' ')  !== false ) {

            $val = '"' . $val . '"';
        }

        return $val . $this->separator;
    }

    /**
     * This function handles subarrays, by flattening
     *
     * @param $arr
     * @return string
     */
    public function csv_implode($arr) {
        $r = "";

        foreach( $arr as $v ) {
            if ( is_array($v) ) {
                $r .= $this->csv_implode($v);
            } else {
                $r .= $this->value($v);
            }
        }

        return $r;
    }

    private function is_multi_array($arr) {
        sort($arr);
        return isset( $arr[0] ) && is_array( $arr[0] );
    }

}
