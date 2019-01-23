import com.google.inject.AbstractModule;

public class Module extends AbstractModule {
    @Override
    public void configure(){
        bind(OnStartup.class).asEagerSingleton();
    }

}
