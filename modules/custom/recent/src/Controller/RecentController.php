<?php

namespace Drupal\recent\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 *
 */
class RecentController extends ControllerBase {

  public function recentArticle() {
    $connection = \Drupal::database();
    $query = $connection->query("SELECT nid FROM node WHERE type = 'article'");
    $articles = $query->fetchAll();

    $markup = '<div class="container">';
    foreach ($articles as $article) {
      $node_load = Node::load($article->nid);

      $markup .= '<div>';
      $markup .= '<h2><a href="/node/' . $article->nid .'">' . $node_load->getTitle() . '</a></h2>';
      $markup .= '<div>' . $node_load->body->value . '</div>';
      $markup .= '</div>';
    }
    $markup .= '</div>';

    return [
      '#markup' => '<p>' . $markup . '</p>',
      '#attached' => array(
        'library' => array(
          'recent/recent',
        ),
      ),
    ];
  }
}

