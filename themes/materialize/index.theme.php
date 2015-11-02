<?php

class CustomIndexTheme extends IndexTheme {
	public function display_page(Page $page, $images) {
		global $config;

		if(count($this->search_terms) == 0) {
			$query = null;
			$page_title = $config->get_string('title');
		}
		else {
			$search_string = implode(' ', $this->search_terms);
			$query = url_escape($search_string);
			$page_title = html_escape($search_string);
		}

		$nav = $this->build_navigation($this->page_number, $this->total_pages, $this->search_terms);
		$page->set_title($page_title);
		$page->set_heading($page_title);
		$page->add_block(new Block("Search", $nav, "left", 0));
		if(count($images) > 0) {
			if($query) {
				$page->add_block(new Block("Images", $this->build_table($images, "search=$query"), "main", 10));
				$this->display_paginator($page, "post/list/$query", null, $this->page_number, $this->total_pages);
			}
			else {
				$page->add_block(new Block("Images", $this->build_table($images, null), "main", 10));
				$this->display_paginator($page, "post/list", null, $this->page_number, $this->total_pages);
			}
		}
		else {
			$page->add_block(new Block("No Images Found", "No images were found to match the search criteria"));
		}
	}


	protected function build_navigation($page_number, $total_pages, $search_terms) {
		$h_search_string = count($search_terms) == 0 ? "" : html_escape(implode(" ", $search_terms));
		$h_search_link = make_link();
		$h_search = "
			<div class='centered container' id='search'>
				<form action='./index.php?q=/post/list' method='GET' class='col s12'>
					<div class='input-field'>
						<input id='search' type='search' required>
						<input type='hidden' name='q' value='/post/list'>
						<label for='search'><i class='material-icons'>search</i></label>
						<i class='material-icons'>close</i>
					</div>
				</form>
			</div>";

		return $h_search;
	}

	protected function build_table($images, $query) {
		$h_query = html_escape($query);
		$table = "<div class='shm-image-list' data-query='$h_query'>";
		foreach($images as $image) {
			$table .= "\t<span class=\"thumb\">" . $this->build_thumb_html($image) . "</span>\n";
		}
		$table .= "</div>";
		return $table;
	}
}

