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
      $markup .= '</div>';
    }
    $markup .= '</div>';

    return [
      '#markup' => '<p>' . $markup . '</p>',
    ];
  }
}
