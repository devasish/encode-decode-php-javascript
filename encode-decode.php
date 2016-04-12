<?php
$str = encode_str("19876");
echo '<br/>'.$str.'<br/>' ;
echo decode_str($str);

/**
 * 1. Get ASCII of each char add an random salt and again add with an random multple (1x to 9x) of 1000 to keep each unit 4 char length.
 * 2. Convert 0, 1, 2, 3, 4, 5  in obtained string to alphabet 
 * @param string $str
 * @return type
 * 
 */
function encode_str($str) {
    $encoded    = '';
    $alpha_map = ['P', 'M', 'S', 'K'];
    $str        = ''.$str;
    $len        = strlen($str);
    $ascii_arr  = [];
    $salt       = 150;//rand(100, (999 - 255)); 
    
    for ($x = 0; $x < $len; $x++) {
        $ascii_arr[$x] = (rand(1, 9) * 1000) + ($salt + ord($str[$x]));
    }
    
    $enc        = implode('', $ascii_arr) . $salt;
    $enc_len    = strlen($enc);
    
    for ($x = 0; $x < $enc_len; $x++) {
        if (array_key_exists($enc[$x], $alpha_map)) {
            $encoded .= $alpha_map[$enc[$x]];
        } else {
            $encoded .= $enc[$x];
        }
    }
    
    return strtolower($encoded);
}

function decode_str($str) {
    $str = strtoupper($str);
    $unit_size = 4;
    $alphatonum = function($s) {
        $alpha_map = ['P', 'M', 'S', 'K'];
        $l = strlen($s);
        $s_ = '';
        for ($x = 0; $x < $l; $x++) {
            $pos = array_search($s[$x], $alpha_map);
            $s_ .= in_array($s[$x], $alpha_map) ? array_search($s[$x], $alpha_map) : $s[$x];
        }
        return $s_;
    };
    
    $decoded    = '';
    $salt       = $alphatonum(substr($str, -3));     
    $data       = $alphatonum(substr($str, 0, strlen($str) - 3));
    
    $loop       = strlen($data) / $unit_size;
    $unit_arr   = [];
    for ($x = 0; $x < $loop; $x++) {
        $unit = substr($data, $x * $unit_size, $unit_size);
        
        $ascii_ = ($unit % 1000) - $salt;
        $decoded .= chr($ascii_);
    }
    
    return $decoded;
}
?>
<script type="text/javascript">
    var encod = encode_str('19');
    console.log(encod)
    console.log(decode_str(encod))
    function encode_str(str) {
        var encoded = '';
        var alpha_map = ['P', 'M', 'S', 'K'];
        var str = str.toString();
        var len = str.length;
        var ascii_arr = [];
        var salt = 150;//rand(100, (999 - 255));
        
        for (var x = 0; x < len; x++) {
            ascii_arr[x] = (rand(1, 9) * 1000) + (salt + str.charCodeAt(x));
        }
        
        var enc = ascii_arr.join('') + salt;
        var enc_len = enc.length;
        
        for (var x = 0; x < enc_len; x++) {
            if (typeof(alpha_map[enc[x]]) != 'undefined') {
                encoded += alpha_map[enc[x]];
            } else {
                encoded += enc[x];
            }
        }
        
        return encoded.toLowerCase();
    }
    
    function decode_str(str) {
        str = str.toUpperCase();
        var unit_size = 4;
        var alphatonum = function(s) {
            var alpha_map = ['P', 'M', 'S', 'K'];
            var l = s.length;
            var s_ = '';
            
            for (var x = 0; x < l; x++) {
                var pos = alpha_map.indexOf(s[x]);
                s_ += (pos >= 0) ? pos : s[x];
            }
            
            return s_;
        };
        
        var decoded = '';
        var salt = alphatonum(str.substr(-3));
        var data = alphatonum(str.substr(0, (str.length - 3)));
        
        var loop = data.length / unit_size;
        
        for (var x = 0; x < loop; x++) {
            var unit = data.substr(x * unit_size, unit_size);
            var ascii_ = (unit % 1000) - salt;
            decoded += String.fromCharCode(ascii_)
        }
        
        return decoded;
    }
    
    function rand(x, y) {
        return parseInt(Math.random() * (y + 1 - x) + x, 10);
    }
</script>