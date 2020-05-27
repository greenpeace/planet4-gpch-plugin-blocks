<?php

namespace Greenpeace\Planet4GPCHBlocks;

if ( ! class_exists( '\WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Planet4_GPCH_Blocks_Dictionary_Table extends \WP_List_Table {
	/*
	 * Display the Word List Table
	 * Callback for the add_users_page() in the add_plugin_admin_menu() method of this class.
	 */
	public function load_word_list_table() {
		// query, filter, and sort the data
		$this->prepare_items();

		// render the List Table
		include_once( 'views/partials-wp-admin-cloud-block-dictionary-table.php' );
	}

	function get_columns() {
		$columns = array(
			'cb' => '<input type="checkbox" />', // Checkbox for bulk actions
			'id'          => 'ID',
			'word'        => 'Word',
			'type'        => 'POS',
			'confirmed'   => 'Confirmed',
			'blacklisted' => 'Blacklisted',
		);

		return $columns;
	}

	function prepare_items() {
		// Check for search string
		$user_search_key = isset( $_REQUEST['s'] ) ? wp_unslash( trim( $_REQUEST['s'] ) ) : '';

		$this->handle_bulk_actions();

		$words_per_page = 20;
		$table_page     = $this->get_pagenum();


		// set the pagination arguments
		$total_words = $this->get_table_data( $words_per_page, $user_search_key, true );

		$this->set_pagination_args( array(
			'total_items' => $total_words[0][0],
			'per_page'    => $words_per_page,
		) );


		$columns               = $this->get_columns();
		$hidden                = array();
		$sortable              = array( 'id', 'word', 'type', 'confirmed', 'blacklisted' );
		$this->_column_headers = array( $columns, $hidden, $sortable );
		$this->items           = $this->get_table_data( $words_per_page, $user_search_key );
	}

	function get_table_data( $limit, $search, $count = false ) {
		global $wpdb;
		$wpdb_table = $wpdb->prefix . "gpch_wordcloud_dictionary";
		$orderby    = ( isset( $_GET['orderby'] ) ) ? esc_sql( $_GET['orderby'] ) : 'id';
		$order      = ( isset( $_GET['order'] ) ) ? esc_sql( $_GET['order'] ) : 'ASC';
		$page       = ( isset( $_REQUEST['paged'] ) ) ? esc_sql( $_REQUEST['paged'] ) : '1';

		$start = ( $limit * $page ) - $limit;

		if ( ! empty( $search ) ) {
			$where = 'WHERE word LIKE \'' . $search . '\'';
		} else {
			$where = '';
		}

		if ( $count ) {
			$query = "SELECT COUNT(*)
                      FROM 
                        $wpdb_table 
                        $where
                      ORDER BY $orderby $order";

			$query_results = $wpdb->get_results( $query, ARRAY_N );
		} else {
			$query = "SELECT 
                        id, word, type, confirmed, blacklisted
                      FROM 
                        $wpdb_table 
                        $where
                      ORDER BY $orderby $order
                      LIMIT $start, $limit ;";

			$query_results = $wpdb->get_results( $query, ARRAY_A );
		}

		// return result array to prepare_items.
		return $query_results;
	}

	public function get_bulk_actions() {
		/*
		 * on hitting apply in bulk actions the url paramas are set as
		 * ?action=bulk-download&paged=1&action2=-1
		 *
		 * action and action2 are set based on the triggers above and below the table
		 */
		$actions = array(
			'blacklist'       => 'Blacklist',
			'unblacklist'     => 'Remove from Blacklist',
			'set-noun'        => 'Set as NOUN',
			'set-proper-noun' => 'Set as PROPER NOUN',
			'set-adjective'   => 'Set as ADJECTIVE',
			'set-verb'        => 'Set as VERB',
			'set-diverse'     => 'Set as DIVERSE',
			'delete'          => 'delete',
		);

		return $actions;
	}

	public function handle_bulk_actions() {
		/*
		 * So, we have two dropdowns in the table where actions can be selected, but Wordpress doesn't seem to think
		 * it's important which button was pressed. We're going to take an educated guess on what action the user
		 * intended to do.
		 */
		if ( isset( $_REQUEST['action2'] ) && $_REQUEST['action2'] != '-1' ) {
			$action = $_REQUEST['action2'];
		} elseif ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] != '-1' ) {
			$action = $_REQUEST['action'];
		}
		global $wpdb;
		$table_name = $wpdb->prefix . "gpch_wordcloud_dictionary";

		if ( isset( $action ) ) {
			$nonce = wp_unslash( $_REQUEST['_wpnonce'] );

			if ( false && ! wp_verify_nonce( $nonce ) ) { // TODO: Verify nonce
				var_dump( 'INVALID NONCE' );
			} elseif ( $action == 'blacklist' ) {
				$ids = $_REQUEST['ba'];

				foreach ( $ids as $id => $value ) {
					$wpdb->update( $table_name, array( 'blacklisted' => 1 ), array( 'id' => $id ) );
				}
			} elseif ( $action == 'unblacklist' ) {
				$ids = $_REQUEST['ba'];

				foreach ( $ids as $id => $value ) {
					$wpdb->update( $table_name, array( 'blacklisted' => 0 ), array( 'id' => $id ) );
				}
			} elseif ( $action == 'set-noun' ) {
				$ids = $_REQUEST['ba'];

				foreach ( $ids as $id => $value ) {
					$wpdb->update( $table_name, array( 'confirmed' => 1, 'type' => 'NN' ), array( 'id' => $id ) );
				}
			} elseif ( $action == 'set-proper-noun' ) {
				$ids = $_REQUEST['ba'];

				foreach ( $ids as $id => $value ) {
					$wpdb->update( $table_name, array( 'confirmed' => 1, 'type' => 'NE' ), array( 'id' => $id ) );
				}
			} elseif ( $action == 'set-adjective' ) {
				$ids = $_REQUEST['ba'];

				foreach ( $ids as $id => $value ) {
					$wpdb->update( $table_name, array( 'confirmed' => 1, 'type' => 'ADJ' ), array( 'id' => $id ) );
				}
			} elseif ( $action == 'set-verb' ) {
				$ids = $_REQUEST['ba'];

				foreach ( $ids as $id => $value ) {
					$wpdb->update( $table_name, array( 'confirmed' => 1, 'type' => 'VERB' ), array( 'id' => $id ) );
				}
			} elseif ( $action == 'set-diverse' ) {
				$ids = $_REQUEST['ba'];

				foreach ( $ids as $id => $value ) {
					$wpdb->update( $table_name, array( 'confirmed' => 1, 'type' => 'DIV' ), array( 'id' => $id ) );
				}
			} elseif ( $action == 'delete' ) {
				$ids = $_REQUEST['ba'];

				foreach ( $ids as $id => $value ) {
					$wpdb->delete( $table_name, array( 'id' => $id ) );
				}
			}
		}
	}

	/**
	 * Returns default column content
	 *
	 * @param $item
	 * @param $column_name
	 *
	 * @return string|true
	 */
	function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'id':
			case 'word':
			case 'type':
			case 'confirmed':
			case 'blacklisted':
				return $item[ $column_name ];
			default:
				return print_r( $item, true ); //Show the whole array for troubleshooting purposes
		}
	}

	function column_blacklisted( $item ) {
		if ( $item['blacklisted'] === '1' ) {
			return 'Yes';
		} else {
			return "No";
		}
	}

	function column_confirmed( $item ) {
		if ( $item['confirmed'] === '1' ) {
			return 'Yes';
		} else {
			return "No";
		}
	}

	function column_type( $item ) {
		if ( $item['type'] === 'NN' ) {
			return 'Noun';
		} elseif ( $item['type'] === 'NE' ) {
			return 'Proper Noun';
		} elseif ( $item['type'] === 'VERB' ) {
			return 'Verb';
		} elseif ( $item['type'] === 'ADJ' ) {
			return 'Adjective';
		} elseif ( $item['type'] === 'DIV' ) {
			return 'Other';
		} else {
			return $item['type'];
		}
	}

	function column_cb( $item ) {
		return '<input type="checkbox" name="ba[' . $item['id'] . ']">';
	}

	public function get_sortable_columns() {
		return $sortable = array(
			'id'          => array( 'id', false ),
			'word'    => array( 'word', true ),
			'type' => array( 'type', false ),
			'confirmed'           => array( 'confirmed', false ),
			'blacklisted'          => array( 'blacklisted', false ),
		);
	}
}
