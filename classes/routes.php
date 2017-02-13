<?php
	class Route {

		public function handleSubmit($data) {
			foreach ($data as $key => $var) {
				$keys[] = $key;
			}
			for ($i = 0; $i < count($data); $i++) {
				if ($keys[$i] == 'submit') continue;
				if (is_array($data[$keys[$i]])) {
					$x = 0;
					foreach ($data[$keys[$i]] as $embeded) {
						($x == 0) ? $data[$keys[$i]] = $embeded : $data[$keys[$i]] .= ' -> ' . $embeded;
						$x++;
					}
				}
				(isset($redirect)) ? $redirect .= '&'.$keys[$i].'='.$data[$keys[$i]] : $redirect = '?'.$keys[$i].'='.$data[$keys[$i]];
			}

			return $redirect;
		}

	}