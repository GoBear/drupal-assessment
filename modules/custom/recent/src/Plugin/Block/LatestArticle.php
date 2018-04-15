<?php

/**
 * @file
 * Contains \Drupal\recent\Plugin\Block\LatestArticle.
 */

namespace Drupal\recent\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;

/**
 * Provides a 'Latest Article' Block.
 *
 * @Block(
 *   id = "recent_latest_article",
 *   admin_label = @Translation("Recent Latest Article"),
 * )
 */
class LatestArticle extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    $connection = \Drupal::database();
    $query = $connection->query("SELECT nid FROM node WHERE type = 'article' LIMIT 0,5");
    $articles = $query->fetchAll();

    $markup = '<div class="container">';
    foreach ($articles as $article) {
      $node_load = Node::load($article->nid);

      $markup .= '<div>';
      $markup .= '<h2><a href="/node/' . $article->nid .'">' . $node_load->getTitle() . '</a></h2>';
      $markup .= '</div>';
    }
    $markup .= '</div>';

    return [
      '#markup' => '<p>' . $markup . '</p>',
    ];
  }
}
