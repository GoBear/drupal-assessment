<?php

namespace Drupal\recent\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\node\Entity\Node;

/**
 *
 */
class RecentController extends ControllerBase {

  public function recentArticle() {
    $query = Database::getConnection()
      ->select('node', 'node')
      ->fields('node', ['nid'])
      ->condition('type', 'article', '=');
    $articles = $query->execute()->fetchCol();
    $markup = '<div class="container">';
    foreach ($articles as $key => $nid) {
      $node_load = Node::load($nid);

      $markup .= '<div>';
      $markup .= '<h2><a href="/node/' . $nid . '">' . $node_load->getTitle() . '</a></h2>';
      $markup .= '<div>' . $node_load->body->value . '</div>';
      $markup .= '</div>';
    }
    $markup .= '</div>';

    return [
      '#markup' => '<p>' . $markup . '</p>',
      '#attached' => [
        'library' => [
          'recent/recent',
        ],
      ],
    ];
  }
}

