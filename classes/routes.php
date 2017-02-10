<?php
	class Route {

		public function handleSubmit($data) {
			foreach ($data as $key => $var) {
				$keys[] = $key;
			}
			for ($i = 0; $i < count($data); $i++) {
				if ($keys[$i] == 'submit') continue;
				(isset($redirect)) ? $redirect .= '&'.$keys[$i].'='.$data[$keys[$i]] : $redirect = '?'.$keys[$i].'='.$data[$keys[$i]];
			}

			return $redirect;
		}

	}