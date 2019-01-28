<?php namespace Spiroski\Domain\Events;


use PHPUnit\Framework\TestCase;

class BasicDispatcherTest extends TestCase
{

    public function testDispatchForListeners()
    {
        $dispatcher = new BasicDispatcher();

        $event1 = $this->getMockBuilder(Event::class)
            ->setMockClassName('Event1')
            ->getMock();
        $event2 = $this->getMockBuilder(Event::class)
            ->setMockClassName('Event2')
            ->getMock();
        $event3 = $this->getMockBuilder(Event::class)
            ->setMockClassName('Event3')
            ->getMock();

        $listener1 = $this->getMockBuilder(Listener::class)
            ->setMethods(['handle'])
            ->getMock();

        $listener1->expects($this->once())
            ->method('handle')
            ->with($event1);

        $listener2 = $this->getMockBuilder(Listener::class)
            ->setMethods(['handle'])
            ->getMock();

        $listener2->expects($this->once())
            ->method('handle')
            ->with($event2);

        $listener3 = $this->getMockBuilder(Listener::class)
            ->setMethods(['handle'])
            ->getMock();

        $listener3->expects($this->exactly(2))
            ->method('handle')
            ->with($event3);


        $dispatcher->registerListener(get_class($event1), $listener1);
        $dispatcher->registerListener(get_class($event2), $listener2);
        $dispatcher->registerListener(get_class($event3), $listener3);

        $dispatcher->dispatch([$event1, $event2, $event3, $event3]);

    }

    public function testDispatchForSubscribers()
    {
        $dispatcher = new BasicDispatcher();

        $event1 = $this->getMockBuilder(Event::class)
            ->setMockClassName('Event1')
            ->getMock();
        $event2 = $this->getMockBuilder(Event::class)
            ->setMockClassName('Event2')
            ->getMock();
        $event3 = $this->getMockBuilder(Event::class)
            ->setMockClassName('Event3')
            ->getMock();

        $subscriber1 = $this->getMockBuilder(Subscriber::class)
            ->setMethods(['getSubscribedEvents', 'handleEvent1', 'handleEvent2'])
            ->getMock();

        $subscriber1->method('getSubscribedEvents')
            ->willReturn([
                get_class($event1) => 'handleEvent1',
                get_class($event2) => 'handleEvent2',
            ]);

        $subscriber1->expects($this->once())
            ->method('handleEvent1')
            ->with($event1);

        $subscriber1->expects($this->once())
            ->method('handleEvent2')
            ->with($event2);

        $subscriber2 = $this->getMockBuilder(Subscriber::class)
            ->setMethods(['getSubscribedEvents', 'handleEvent2'])
            ->getMock();

        $subscriber2->method('getSubscribedEvents')
            ->willReturn([
                get_class($event2) => 'handleEvent2',
            ]);

        $subscriber2->expects($this->once())
            ->method('handleEvent2')
            ->with($event2);


        $subscriber3 = $this->getMockBuilder(Subscriber::class)
            ->setMethods(['getSubscribedEvents', 'handleEvent2', 'handleEvent3'])
            ->getMock();

        $subscriber3->method('getSubscribedEvents')
            ->willReturn([
                get_class($event2) => 'handleEvent2',
                get_class($event3) => 'handleEvent3',
            ]);

        $subscriber3->expects($this->once())
            ->method('handleEvent2')
            ->with($event2);

        $subscriber3->expects($this->exactly(2))
            ->method('handleEvent3')
            ->with($event3);


        $dispatcher->registerSubscriber($subscriber1);
        $dispatcher->registerSubscriber($subscriber2);
        $dispatcher->registerSubscriber($subscriber3);

        $dispatcher->dispatch([$event1, $event2, $event3, $event3]);

    }

}
