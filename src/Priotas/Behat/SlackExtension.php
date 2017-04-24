<?

namespace Priotas\Behat;

use Behat\Behat\Context\ServiceContainer\ContextExtension;
use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class SlackExtension implements Extension
{
    /**
     * Returns the extension config key.
     *
     * @return string
     */
    public function getConfigKey()
    {
        return "slack";
    }

    /**
     * Initializes other extensions.
     *
     * This method is called immediately after all extensions are activated but
     * before any extension `configure()` method is called. This allows extensions
     * to hook into the configuration of other extensions providing such an
     * extension point.
     *
     * @param ExtensionManager $extensionManager
     */
    public function initialize(ExtensionManager $extensionManager)
    {
    }

    /**
     * Setups configuration for the extension.
     *
     * @param ArrayNodeDefinition $builder
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('slackToken')->end()
                ->scalarNode('slackChannel')->end()
            ->end();
    }

    /**
     * Loads extension services into temporary container.
     *
     * @param ContainerBuilder $container
     * @param array            $config
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $container->setDefinition('slack.channel', new Definition(
            'Priotas\\Behat\\SlackChannel',
            [ $config['slackToken'], $config['slackChannel'] ]
        ));
        $definition = new Definition('Priotas\\Behat\\SlackContextInitializer', array(
            new Reference('slack.channel')
        ));
        $definition->addTag(ContextExtension::INITIALIZER_TAG, array('priority' => 0));
        $container->setDefinition('slack.context_initializer', $definition);
    }

    public function process(ContainerBuilder $container)
    {
    }
}
